<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // 🔹 Afficher toutes les notes
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Note::with(['eleve', 'matiere'])
                     ->whereHas('eleve')
                     ->whereHas('matiere');

        // Filtrage selon le rôle
        if ($user->role === 'eleve') {
            // Un élève ne voit que ses notes
            $query->whereHas('eleve', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        } elseif ($user->role === 'parent') {
            // Un parent ne voit que les notes de ses enfants
            $query->whereHas('eleve.parent', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            
            // Si un eleve_id spécifique est passé, filtrer encore plus
            if ($request->has('eleve_id')) {
                $query->where('eleve_id', $request->eleve_id);
            }
        } elseif ($user->role === 'enseignant') {
            // Optionnel: filtrer par les classes/matières de l'enseignant
            // Pour l'instant, on laisse l'accès si c'est un enseignant
        }

        $notes = $query->latest()->get();
        return view('notes.index', compact('notes'));
    }
    

    // 🔹 Formulaire de création (individuel)
    public function create() {
        $user = auth()->user();
        
        if (!in_array($user->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403, 'Action non autorisée.');
        }

        if ($user->role === 'enseignant') {
            $enseignant = \App\Models\Enseignant::where('user_id', $user->id)->first();
            
            if (!$enseignant) {
                return redirect()->route('dashboard')->with('error', "Votre profil d'enseignant n'est pas encore configuré.");
            }

            $eleves = \App\Models\Eleve::whereIn('classe_id', $enseignant->classes->pluck('id'))->get();
            $matieres = $enseignant->matieres;
        } else {
            $eleves = \App\Models\Eleve::all();
            $matieres = \App\Models\Matiere::all();
        }
        $annee_scolaire = '2025-2026';
        
        return view('notes.create', compact('eleves', 'matieres', 'annee_scolaire')); 
    }

    // 🔹 Formulaire de saisie par classe (Batch Grid)
    public function createBatch(Request $request)
    {
        $user = auth()->user();
        
        if (!in_array($user->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403, 'Action non autorisée.');
        }

        if ($user->role === 'enseignant') {
            $enseignant = \App\Models\Enseignant::where('user_id', $user->id)->first();
            if (!$enseignant) {
                return redirect()->route('dashboard')->with('error', "Votre profil d'enseignant n'est pas encore configuré.");
            }
            $classes = $enseignant->classes;
            $matieres = $enseignant->matieres;
        } else {
            $classes = \App\Models\Classe::all();
            $matieres = \App\Models\Matiere::all();
        }

        $eleves = [];
        $existingNotes = [];
        $selectedClass = $request->classe_id;
        $selectedMatiere = $request->matiere_id;
        $type_periode = $request->type_periode ?? 'Trimestre';
        $numero_periode = $request->numero_periode ?? 1;
        $annee_scolaire = $request->annee_scolaire ?? '2025-2026';

        if ($selectedClass && $selectedMatiere) {
            $eleves = \App\Models\Eleve::where('classe_id', $selectedClass)->get();
            
            // Récupérer les notes existantes pour pré-remplir le tableau
            $notes = Note::where('matiere_id', $selectedMatiere)
                ->where('type_periode', $type_periode)
                ->where('numero_periode', $numero_periode)
                ->where('annee_scolaire', $annee_scolaire)
                ->whereIn('eleve_id', $eleves->pluck('id'))
                ->get();
            
            foreach ($notes as $note) {
                $key = $note->type_evaluation . '_' . $note->num_evaluation;
                $existingNotes[$note->eleve_id][$key] = $note->note;
            }
        }

        return view('notes.batch_create', compact('classes', 'matieres', 'eleves', 'selectedClass', 'selectedMatiere', 'existingNotes', 'type_periode', 'numero_periode', 'annee_scolaire'));
    }

    // 🔹 Enregistrer une nouvelle note
    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403);
        }
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|integer|min:1',
            'numero_periode' => 'required|integer|min:1|max:3',
            'type_periode' => 'required|in:Trimestre,Semestre',
            'type_evaluation' => 'required|in:Interrogation,Devoir,Composition',
            'num_evaluation' => 'required|integer|min:1|max:3',
        ]);

        $validated['annee_scolaire'] = '2025-2026';
        Note::create($validated);

        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès ✅');
    }

    // 🔹 Enregistrer des notes par classe (Batch Grid)
    public function storeBatch(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403);
        }
        
        try {
            $validated = $request->validate([
                'matiere_id' => 'required|exists:matieres,id',
                'type_periode' => 'required|in:Trimestre,Semestre',
                'numero_periode' => 'required|integer|min:1|max:3',
                'coefficient' => 'required|integer|min:1',
                'notes' => 'required|array',
            ]);

            $annee_scolaire = '2025-2026';

            $evaluations = [
                ['type' => 'Interrogation', 'num' => 1],
                ['type' => 'Interrogation', 'num' => 2],
                ['type' => 'Interrogation', 'num' => 3],
                ['type' => 'Devoir', 'num' => 1],
                ['type' => 'Devoir', 'num' => 2],
                ['type' => 'Composition', 'num' => 1],
            ];

            $countSaves = 0;
            foreach ($request->notes as $eleve_id => $eval_notes) {
                foreach ($evaluations as $eval) {
                    $key = $eval['type'] . '_' . $eval['num'];
                    $note_val = $eval_notes[$key] ?? null;

                    if ($note_val !== null && $note_val !== '') {
                        Note::updateOrCreate(
                            [
                                'eleve_id' => $eleve_id,
                                'matiere_id' => $request->matiere_id,
                                'type_periode' => $request->type_periode,
                                'numero_periode' => $request->numero_periode,
                                'type_evaluation' => $eval['type'],
                                'num_evaluation' => $eval['num'],
                                'annee_scolaire' => $annee_scolaire,
                            ],
                            [
                                'note' => $note_val,
                                'coefficient' => $request->coefficient,
                            ]
                        );
                        $countSaves++;
                    }
                }
            }

            return redirect()->back()->with('success', "$countSaves notes ont été enregistrées avec succès ✅");
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error in storeBatch: ' . $e->getMessage());
            return redirect()->back()->withErrors('Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage())->withInput();
        }
    }

    // 🔹 Afficher une note spécifique
    public function show($id)
    {
        $note = Note::with(['eleve', 'matiere'])->findOrFail($id);
        
        // Vérifier les permissions
        $user = auth()->user();
        if ($user->role === 'eleve') {
            if ($note->eleve->user_id !== $user->id) {
                abort(403, 'Accès non autorisé.');
            }
        } elseif ($user->role === 'parent') {
            if ($note->eleve->parent->user_id !== $user->id) {
                abort(403, 'Accès non autorisé.');
            }
        }
        
        return view('notes.show', compact('note'));
    }

    // 🔹 Formulaire d'édition
    public function edit($id)
    {
        $user = auth()->user();
        
        if (!in_array($user->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403, 'Action non autorisée.');
        }

        $note = Note::with(['eleve', 'matiere'])->findOrFail($id);
        
        if ($user->role === 'enseignant') {
            $enseignant = \App\Models\Enseignant::where('user_id', $user->id)->first();
            $eleves = \App\Models\Eleve::whereIn('classe_id', $enseignant->classes->pluck('id'))->get();
            $matieres = $enseignant->matieres;
        } else {
            $eleves = \App\Models\Eleve::all();
            $matieres = \App\Models\Matiere::all();
        }
        
        return view('notes.edit', compact('note', 'eleves', 'matieres'));
    }

    // 🔹 Mettre à jour une note
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        
        if (!in_array($user->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403, 'Action non autorisée.');
        }

        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|integer|min:1',
            'type_evaluation' => 'required|in:Interrogation,Devoir,Composition',
            'num_evaluation' => 'required|integer|min:1',
            'type_periode' => 'required|in:Trimestre,Semestre',
            'numero_periode' => 'required|integer|min:1|max:3',
            'annee_scolaire' => 'required|string',
        ]);

        $note = Note::findOrFail($id);
        $note->update($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Note mise à jour avec succès.');
    }

    // 🔹 Supprimer une note
    public function destroy($id)
    {
        $user = auth()->user();
        
        if (!in_array($user->role, ['admin', 'secretaire', 'enseignant'])) {
            abort(403, 'Action non autorisée.');
        }

        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note supprimée avec succès.');
    }
}