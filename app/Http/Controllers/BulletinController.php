<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Note;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BulletinController extends Controller
{
    public function index()
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
        }

        $bulletins = $query->latest()->get();
        return view('Bulletins.index', compact('bulletins'));
    }

    public function create()
    {
        $eleves = Eleve::all();
        return view('Bulletins.create', compact('eleves'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'type_periode' => 'required|in:Trimestre,Semestre',
            'numero_periode' => 'required|integer|min:1|max:3',
            'annee_scolaire' => 'required|string',
        ]);

        $periode = $validated['type_periode'] . '-' . $validated['numero_periode'];
        $data = $this->calculateBulletin($validated['eleve_id'], $periode);

        \App\Models\Bulletin::updateOrCreate(
            [
                'eleve_id' => $validated['eleve_id'],
                'type_periode' => $validated['type_periode'],
                'numero_periode' => $validated['numero_periode'],
                'annee_scolaire' => $validated['annee_scolaire']
            ],
            [
                'moyenne' => $data['moyenneGenerale']
            ]
        );

        return redirect()->route('bulletins.index')->with('success', 'Bulletin calculé et enregistré avec succès.');
    }

    public function show($eleve_id, $periode)
    {
        $data = $this->calculateBulletin($eleve_id, $periode);
        return view('Bulletins.show', $data);
    }

    public function exportPdf($eleve_id, $periode)
    {
        $data = $this->calculateBulletin($eleve_id, $periode);
        $pdf = Pdf::loadView('Bulletins.pdf', $data);
        return $pdf->download("bulletin-{$eleve_id}-{$periode}.pdf");
    }

    private function calculateBulletin($eleve_id, $periode)
    {
        $eleve = Eleve::with('classe')->findOrFail($eleve_id);
        
        // Parse period format "Type-Numero" e.g. "Trimestre-1"
        $parts = explode('-', $periode);
        $type = $parts[0] ?? 'Trimestre';
        $numero = $parts[1] ?? 1;

        $notes = Note::where('eleve_id', $eleve_id)
                     ->where('type_periode', $type)
                     ->where('numero_periode', $numero)
                     ->with('matiere')
                     ->get();

        $matieres = $notes->groupBy('matiere_id');
        $resultats = [];
        $totalPoints = 0;
        $totalCoef = 0;

        foreach ($matieres as $matiere_id => $group) {
            $matiere = $group->first()->matiere;
            $avg = $group->avg('note');
            $coef = $matiere->coefficient ?? 1;
            
            $resultats[] = [
                'matiere' => $matiere->nom ?? 'Matière inconnue',
                'moyenne' => $avg,
                'coef' => $coef,
                'points' => $avg * $coef
            ];

            $totalPoints += $avg * $coef;
            $totalCoef += $coef;
        }

        $moyenneGenerale = $totalCoef > 0 ? $totalPoints / $totalCoef : 0;

        return compact('eleve', 'periode', 'resultats', 'moyenneGenerale');
    }
}
