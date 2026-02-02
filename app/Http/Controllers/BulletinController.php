<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Note;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BulletinController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = \App\Models\Bulletin::with(['eleve.classe']);

        if ($user->role === 'eleve') {
            $query->whereHas('eleve', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($user->role === 'parent') {
            $query->whereHas('eleve.parent', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            
            // Si un eleve_id spécifique est passé, filtrer encore plus
            if ($request->has('eleve_id')) {
                $query->where('eleve_id', $request->eleve_id);
            }
        }

        $bulletins = $query->latest()->get();
        return view('Bulletins.index', compact('bulletins'));
    }

    public function classSummary(Request $request)
    {
        $classes = \App\Models\Classe::all();
        $selectedClass = $request->classe_id;
        $type = $request->type_periode ?? 'Trimestre';
        $numero = $request->numero_periode ?? 1;

        $bulletins = [];
        if ($selectedClass) {
            $eleves = Eleve::where('classe_id', $selectedClass)->get();
            $periode = $type . '-' . $numero;
            
            // 1. Calculer les moyennes de tous les élèves de la classe en un seul passage
            $classeAverages = [];
            foreach ($eleves as $eleve) {
                // On récupère juste la moyenne sans recalculer le rang à chaque fois
                $result = $this->getStudentAverageOnly($eleve->id, $type, $numero);
                if ($result['has_notes']) {
                    $classeAverages[] = [
                        'eleve' => $eleve,
                        'eleve_id' => $eleve->id,
                        'moyenne' => $result['moyenne'],
                    ];
                }
            }

            // 2. Trier pour déterminer les rangs
            usort($classeAverages, function($a, $b) {
                return $b['moyenne'] <=> $a['moyenne'];
            });

            // 3. Formater pour la vue
            foreach ($classeAverages as $index => $item) {
                $bulletins[] = (object)[
                    'eleve' => $item['eleve'],
                    'eleve_id' => $item['eleve_id'],
                    'moyenne' => $item['moyenne'],
                    'rang' => $index + 1,
                    'type_periode' => $type,
                    'numero_periode' => $numero,
                ];
            }
        }

        return view('Bulletins.summary', compact('classes', 'bulletins', 'selectedClass', 'type', 'numero'));
    }

    private function getStudentAverageOnly($eleve_id, $type, $numero)
    {
        $notes = Note::where('eleve_id', $eleve_id)
            ->where('type_periode', $type)
            ->where('numero_periode', $numero)
            ->get();

        if ($notes->isEmpty()) {
            return ['has_notes' => false, 'moyenne' => 0];
        }

        $totalPoints = 0;
        $totalCoef = 0;

        foreach ($notes->groupBy('matiere_id') as $matiere_id => $group) {
            $si = $group->where('type_evaluation', 'Interrogation');
            $sd = $group->where('type_evaluation', 'Devoir');
            $sc = $group->where('type_evaluation', 'Composition')->first();
            $coef = $group->first()->matiere->coefficient ?? 1;

            $smi = $si->count() > 0 ? $si->avg('note') : 0;
            $stcc = $smi + $sd->sum('note');
            $sccc = 1 + $sd->count();
            $smc = $stcc / $sccc;
            $moyMatiere = $sc ? ($smc * 2 + $sc->note) / 3 : $smc;

            $totalPoints += $moyMatiere * $coef;
            $totalCoef += $coef;
        }

        return [
            'has_notes' => true,
            'moyenne' => $totalCoef > 0 ? $totalPoints / $totalCoef : 0
        ];
    }

    public function create()
    {
        $eleves = Eleve::all();
        $classes = \App\Models\Classe::all();
        $annee_scolaire = '2025-2026';
        return view('Bulletins.create', compact('eleves', 'classes', 'annee_scolaire'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_periode' => 'required|in:Trimestre,Semestre',
            'numero_periode' => 'required|integer|min:1|max:3',
        ]);

        try {
            $annee_scolaire = '2025-2026';
            if ($request->filled('classe_id')) {
                $eleves = Eleve::where('classe_id', $request->classe_id)->get();
                if ($eleves->isEmpty()) {
                    return back()->withErrors(['classe_id' => 'Aucun élève trouvé dans cette classe.'])->withInput();
                }
                foreach ($eleves as $eleve) {
                    $this->saveBulletin($eleve->id, $request->type_periode, $request->numero_periode, $annee_scolaire);
                }
                return redirect()->route('bulletins.index')->with('success', "Bulletins de la classe calculés et historisés avec succès.");
            } elseif ($request->filled('eleve_id')) {
                $this->saveBulletin($request->eleve_id, $request->type_periode, $request->numero_periode, $annee_scolaire);
                return redirect()->route('bulletins.index')->with('success', 'Bulletin calculé et historisé avec succès.');
            } else {
                return back()->withErrors(['error' => 'Veuillez sélectionner soit un élève, soit une classe.'])->withInput();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erreur Bulletin Store: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue : ' . $e->getMessage()])->withInput();
        }
    }

    private function saveBulletin($eleve_id, $type_periode, $numero_periode, $annee_scolaire)
    {
        $periode = $type_periode . '-' . $numero_periode;
        $data = $this->calculateBulletin($eleve_id, $periode);

        \App\Models\Bulletin::updateOrCreate(
            [
                'eleve_id' => $eleve_id,
                'type_periode' => $type_periode,
                'numero_periode' => $numero_periode,
                'annee_scolaire' => $annee_scolaire
            ],
            [
                'moyenne' => $data['moyenneGenerale']
            ]
        );
    }

    public function show($eleve_id, $periode)
    {
        $data = $this->calculateBulletin($eleve_id, $periode);
        return view('Bulletins.show', $data);
    }

    public function exportPdf($eleve_id, $periode)
    {
        $user = auth()->user();
        $eleve = Eleve::findOrFail($eleve_id);

        // Security check for students and parents
        if ($user->role === 'eleve' && $eleve->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }
        if ($user->role === 'parent' && $eleve->parent->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }

        $data = $this->calculateBulletin($eleve_id, $periode);
        $pdf = Pdf::loadView('Bulletins.pdf', $data);
        return $pdf->download("bulletin-{$eleve->nomComplet}-{$periode}.pdf");
    }

    public function exportClassPdf(Request $request)
    {
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'type_periode' => 'required|in:Trimestre,Semestre',
            'numero_periode' => 'required|integer',
        ]);

        $classe = \App\Models\Classe::findOrFail($validated['classe_id']);
        $eleves = Eleve::where('classe_id', $validated['classe_id'])->get();
        $periode = $validated['type_periode'] . '-' . $validated['numero_periode'];

        $allBulletinsData = [];
        foreach ($eleves as $eleve) {
            $allBulletinsData[] = $this->calculateBulletin($eleve->id, $periode);
        }

        if (empty($allBulletinsData)) {
            return back()->with('error', 'Aucune note trouvée pour cette classe et cette période.');
        }

        $pdf = Pdf::loadView('Bulletins.batch_pdf', ['allData' => $allBulletinsData]);
        return $pdf->download("bulletins-{$classe->nom}-{$periode}.pdf");
    }

    private function calculateBulletin($eleve_id, $periode)
    {
        $eleve = Eleve::with('classe')->findOrFail($eleve_id);
        $classe_id = $eleve->classe_id;
        
        $parts = explode('-', $periode);
        $type = $parts[0] ?? 'Trimestre';
        $numero = $parts[1] ?? 1;

        // Toutes les notes de l'élève pour la période
        $notesEleve = Note::where('eleve_id', $eleve_id)
                     ->where('type_periode', $type)
                     ->where('numero_periode', $numero)
                     ->with('matiere')
                     ->get();

        // Récupérer tous les élèves de la classe pour les stats
        $elevesClasse = Eleve::where('classe_id', $classe_id)->pluck('id');
        
        // Toutes les notes de la classe pour cette période
        $allNotesClasse = Note::whereIn('eleve_id', $elevesClasse)
                              ->where('type_periode', $type)
                              ->where('numero_periode', $numero)
                              ->get()
                              ->groupBy('matiere_id');

        $matieres = $notesEleve->groupBy('matiere_id');
        $resultats = [];
        $totalPoints = 0;
        $totalCoef = 0;

        foreach ($matieres as $matiere_id => $group) {
            $matiere = $group->first()->matiere;
            $coef = $matiere->coefficient ?? 1;

            // Separate notes by type
            $interros = $group->where('type_evaluation', 'Interrogation');
            $devoirs = $group->where('type_evaluation', 'Devoir');
            $composition = $group->where('type_evaluation', 'Composition')->first();

            // Calculate Averages
            $moyInterro = $interros->count() > 0 ? $interros->avg('note') : 0;
            
            // Moyenne de classe (Contrôle Continu) = (Moy Interro + Devoirs) / N
            // Standard: (Moy Interro + Devoir 1 + Devoir 2) / 3
            $totalCC = $moyInterro;
            $countCC = 1;
            foreach ($devoirs as $d) {
                $totalCC += $d->note;
                $countCC++;
            }
            $moyenneClasse = $countCC > 0 ? $totalCC / $countCC : 0;

            // Moyenne Trimestrielle = (Moyenne Classe * 2 + Composition) / 3
            if ($composition) {
                $moyenneMatiere = ($moyenneClasse * 2 + $composition->note) / 3;
            } else {
                $moyenneMatiere = $moyenneClasse;
            }
            
            // Stats de classe for this subject (Global)
            $notesMatiereClasse = $allNotesClasse->get($matiere_id);
            $moyenneClasseGlobale = 0;
            $maxMatiere = 0;
            $minMatiere = 0;

            if ($notesMatiereClasse) {
                // To get class average, we need to calculate the subject average for EACH student first
                $studentAverages = $notesMatiereClasse->groupBy('eleve_id')->map(function($studentNotes) {
                    $si = $studentNotes->where('type_evaluation', 'Interrogation');
                    $sd = $studentNotes->where('type_evaluation', 'Devoir');
                    $sc = $studentNotes->where('type_evaluation', 'Composition')->first();
                    
                    $smi = $si->count() > 0 ? $si->avg('note') : 0;
                    $stcc = $smi + $sd->sum('note');
                    $sccc = 1 + $sd->count();
                    $smc = $stcc / $sccc;
                    
                    return $sc ? ($smc * 2 + $sc->note) / 3 : $smc;
                });
                $moyenneClasseGlobale = $studentAverages->avg();
                $maxMatiere = $studentAverages->max();
                $minMatiere = $studentAverages->min();
            }

            $resultats[] = [
                'matiere' => $matiere->nom ?? 'Matière inconnue',
                'interro1' => $interros->where('num_evaluation', 1)->first()->note ?? null,
                'interro2' => $interros->where('num_evaluation', 2)->first()->note ?? null,
                'interro3' => $interros->where('num_evaluation', 3)->first()->note ?? null,
                'devoir1' => $devoirs->where('num_evaluation', 1)->first()->note ?? null,
                'devoir2' => $devoirs->where('num_evaluation', 2)->first()->note ?? null,
                'composition' => $composition->note ?? null,
                'moyenne_classe_cc' => $moyenneClasse,
                'moyenne' => $moyenneMatiere, // This is the final subject average
                'coef' => $coef,
                'points' => $moyenneMatiere * $coef,
                'moyenne_classe' => $moyenneClasseGlobale,
                'max' => $maxMatiere,
                'min' => $minMatiere,
                'appreciation' => $this->getAppreciation($moyenneMatiere)
            ];

            $totalPoints += $moyenneMatiere * $coef;
            $totalCoef += $coef;
        }

        $moyenneGenerale = $totalCoef > 0 ? $totalPoints / $totalCoef : 0;

        // Calcul du rang
        $rang = $this->calculateRank($classe_id, $type, $numero, $moyenneGenerale);

        return compact('eleve', 'periode', 'resultats', 'moyenneGenerale', 'rang', 'totalPoints', 'totalCoef');
    }

    private function calculateRank($classe_id, $type, $numero, $moyenneEleve)
    {
        $elevesIds = Eleve::where('classe_id', $classe_id)->pluck('id');
        $allNotes = Note::whereIn('eleve_id', $elevesIds)
                        ->where('type_periode', $type)
                        ->where('numero_periode', $numero)
                        ->with('matiere')
                        ->get();

        $moyennes = [];
        foreach ($allNotes->groupBy('eleve_id') as $e_id => $notes) {
            $tPoints = 0;
            $tCoef = 0;
            foreach ($notes->groupBy('matiere_id') as $m_id => $group) {
                $si = $group->where('type_evaluation', 'Interrogation');
                $sd = $group->where('type_evaluation', 'Devoir');
                $sc = $group->where('type_evaluation', 'Composition')->first();
                
                $coef = $group->first()->matiere->coefficient ?? 1;

                $smi = $si->count() > 0 ? $si->avg('note') : 0;
                $stcc = $smi + $sd->sum('note');
                $sccc = 1 + $sd->count();
                $smc = $stcc / $sccc;
                
                $moyMatiere = $sc ? ($smc * 2 + $sc->note) / 3 : $smc;
                
                $tPoints += $moyMatiere * $coef;
                $tCoef += $coef;
            }
            $moyennes[] = $tCoef > 0 ? $tPoints / $tCoef : 0;
        }

        rsort($moyennes);
        $rank = array_search($moyenneEleve, $moyennes) + 1;
        
        return [
            'position' => $rank,
            'total' => count($moyennes)
        ];
    }

    private function getAppreciation($note)
    {
        if ($note >= 18) return 'Excellent';
        if ($note >= 16) return 'Très Bien';
        if ($note >= 14) return 'Bien';
        if ($note >= 12) return 'Assez Bien';
        if ($note >= 10) return 'Passable';
        if ($note >= 8) return 'Insuffisant';
        return 'Médiocre';
    }

    public function destroy($id)
    {
        $bulletin = \App\Models\Bulletin::findOrFail($id);
        $bulletin->delete();
        
        return redirect()->route('bulletins.index')
            ->with('success', 'Bulletin supprimé avec succès.');
    }

}
