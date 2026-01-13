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
        $eleves = Eleve::all();
        return view('Bulletins.index', compact('eleves'));
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
        $eleve = Eleve::findOrFail($eleve_id);
        
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
