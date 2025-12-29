<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Bulletin;
use App\Models\Note;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BulletinController extends Controller
{
    // Afficher le bulletin d’un élève
    public function show($eleveId)
    {
        $eleve = Eleve::with('classe')->findOrFail($eleveId);
        $bulletins = Bulletin::where('eleve_id', $eleveId)->get();
        $notes = Note::where('eleve_id', $eleveId)->with('matiere')->get();

        return view('bulletins.show', compact('eleve', 'bulletins', 'notes'));
    }

    // Exporter le bulletin en PDF
    public function exportPdf($eleveId)
    {
        $eleve = Eleve::with('classe')->findOrFail($eleveId);
        $bulletins = Bulletin::where('eleve_id', $eleveId)->get();
        $notes = Note::where('eleve_id', $eleveId)->with('matiere')->get();

        $pdf = Pdf::loadView('bulletins.pdf', compact('eleve', 'bulletins', 'notes'));
        return $pdf->download('bulletin_'.$eleve->nom.'.pdf');
    }

    // Liste des bulletins (optionnel)
    public function index()
    {
        $bulletins = Bulletin::with('eleve.classe')->get();
        return view('bulletins.index', compact('bulletins'));
    }
}