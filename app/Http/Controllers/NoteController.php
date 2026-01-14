<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // 🔹 Afficher toutes les notes
    public function index()
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
        } elseif ($user->role === 'enseignant') {
            // Optionnel: filtrer par les classes/matières de l'enseignant
            // Pour l'instant, on laisse l'accès si c'est un enseignant
        }

        $notes = $query->latest()->get();
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
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'note' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|integer|min:1',
            'numero_periode' => 'required|integer|min:1|max:3',
            'type_periode' => 'required|in:Trimestre,Semestre',
            'annee_scolaire' => 'required|string',
        ]);

        Note::create($validated);

        return redirect()->route('notes.index')->with('success', 'Note ajoutée avec succès ✅');
    }
}