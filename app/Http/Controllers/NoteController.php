<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // 🔹 Afficher toutes les notes
    public function index()
    {
        $notes = Note::with(['eleve', 'matiere'])
                     ->whereHas('eleve')
                     ->whereHas('matiere')
                     ->get();
        return view('notes.index', compact('notes'));
    }
    

    // 🔹 Formulaire de création
    public function create() {
        $eleves = \App\Models\Eleve::all();
        $matieres = \App\Models\Matiere::all();
        return view('notes.create',
        compact('eleves', 'matieres')); }

    // 🔹 Enregistrer une nouvelle note
    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|integer|min:1',
            'trimestre' => 'required|integer|min:1|max:3',
            'annee_scolaire' => 'required|string',
        ]);

        Note::create($request->all());

        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès ✅');
    }
}