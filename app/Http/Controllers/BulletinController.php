<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Eleve;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BulletinController extends Controller
{
    /**
     * Afficher le bulletin d’un élève
     */
    public function show($eleveId, $periode)
    {
        // Préchargement des relations pour éviter N+1
        $eleve = Eleve::with(['classe', 'notes.matiere'])->findOrFail($eleveId);

        // Déterminer si la classe utilise des trimestres (Collège) ou semestres (Lycée)
        $niveau = $eleve->classe->niveau ?? null;
        $lyceeLevels = ['2nde', '1ère', 'Tle'];
        $periodType = in_array($niveau, $lyceeLevels) ? 'semestre' : 'trimestre';

        // Validation de la période
        $periodInt = (int) $periode;
        if ($periodType === 'trimestre' && ! in_array($periodInt, [1, 2, 3])) {
            abort(404);
        }
        if ($periodType === 'semestre' && ! in_array($periodInt, [1, 2])) {
            abort(404);
        }

        // Récupération des bulletins pour la période appropriée
        $bulletins = Bulletin::where('eleve_id', $eleveId)
            ->where($periodType, $periodInt)
            ->get();

        $notes = $eleve->notes; // Les notes sont déjà chargées avec la matière

        return view('bulletins.show', compact('eleve', 'bulletins', 'notes', 'periodType', 'periodInt'));
    }

    /**
     * Exporter le bulletin en PDF
     */
    public function exportPdf($eleveId, $periode)
    {
        $eleve = Eleve::with(['classe', 'notes.matiere'])->findOrFail($eleveId);

        // Même logique que dans show : déterminer le type de période
        $niveau = $eleve->classe->niveau ?? null;
        $lyceeLevels = ['2nde', '1ère', 'Tle'];
        $periodType = in_array($niveau, $lyceeLevels) ? 'semestre' : 'trimestre';

        $periodInt = (int) $periode;
        if ($periodType === 'trimestre' && ! in_array($periodInt, [1, 2, 3])) {
            abort(404);
        }
        if ($periodType === 'semestre' && ! in_array($periodInt, [1, 2])) {
            abort(404);
        }

        $bulletins = Bulletin::where('eleve_id', $eleveId)
            ->where($periodType, $periodInt)
            ->get();
        $notes = $eleve->notes;

        $pdf = Pdf::loadView('bulletins.pdf', compact('eleve', 'bulletins', 'notes', 'periodType', 'periodInt'));

        // Nom du fichier sécurisé et lisible
        $filename = 'bulletin_'.str_replace(' ', '_', $eleve->nom).'_'.$eleve->prenom.'_periode_'.$periodInt.'.pdf';

        return $pdf->download($filename);
    }

    /**
     * Afficher le formulaire de création de bulletin (admin)
     */
    public function create()
    {
        $eleves = Eleve::with('classe')->get();

        return view('bulletins.create', compact('eleves'));
    }

    /**
     * Stocker un bulletin créé manuellement (admin)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'eleve_id' => ['required', 'exists:eleves,id'],
            'annee_scolaire' => ['required', 'string'],
            'periodType' => ['required', Rule::in(['trimestre', 'semestre'])],
            'trimestre' => ['nullable', 'integer', 'min:1', 'max:3', 'required_if:periodType,trimestre'],
            'semestre' => ['nullable', 'integer', 'min:1', 'max:2', 'required_if:periodType,semestre'],
            'moyenne' => ['required', 'numeric', 'min:0', 'max:20'],
        ]);

        $eleve = Eleve::with('classe')->findOrFail($data['eleve_id']);
        $lyceeLevels = ['2nde', '1ère', 'Tle'];
        $expectedType = in_array($eleve->classe->niveau, $lyceeLevels) ? 'semestre' : 'trimestre';

        if ($data['periodType'] !== $expectedType) {
            return back()->withErrors(['periodType' => "Période invalide pour la classe de l'élève (attendu: {$expectedType})."])->withInput();
        }

        $periodValue = ($data['periodType'] === 'trimestre') ? (int) $data['trimestre'] : (int) $data['semestre'];

        // Vérifier s'il existe déjà un bulletin pour la même élève / année / période
        $existingBulletin = Bulletin::where('eleve_id', $eleve->id)
            ->where('annee_scolaire', $data['annee_scolaire'])
            ->where($data['periodType'], $periodValue)
            ->first();

        if ($existingBulletin) {
            // Si l'utilisateur a demandé de remplacer, on met à jour la moyenne
            if ($request->filled('replace_existing')) {
                $existingBulletin->update([
                    'moyenne' => $data['moyenne'],
                ]);

                return redirect()->route('bulletins.show', [$eleve->id, $periodValue])->with('success', 'Bulletin mis à jour avec succès.');
            }

            // Sinon on renvoie une erreur et on fournit un lien vers le bulletin existant
            return back()
                ->withErrors(['duplicate' => 'Un bulletin pour cet élève et cette période existe déjà.'])
                ->with('existing_bulletin', route('bulletins.show', [$eleve->id, $periodValue]))
                ->withInput();
        }

        $bulletin = Bulletin::create([
            'eleve_id' => $eleve->id,
            'trimestre' => ($data['periodType'] === 'trimestre') ? $periodValue : null,
            'semestre' => ($data['periodType'] === 'semestre') ? $periodValue : null,
            'moyenne' => $data['moyenne'],
            'annee_scolaire' => $data['annee_scolaire'],
        ]);

        return redirect()->route('bulletins.show', [$eleve->id, $periodValue])->with('success', 'Bulletin créé avec succès.');
    }

    /**
     * Liste de tous les bulletins
     */
    public function index()
    {
        // Précharger les relations pour éviter N+1 et ne récupérer que les bulletins avec un élève existant
        $bulletins = Bulletin::with('eleve.classe')->whereHas('eleve')->get();

        return view('bulletins.index', compact('bulletins'));
    }
}
