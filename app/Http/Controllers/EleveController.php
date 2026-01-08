<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $query = Eleve::with('classe');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->search.'%')
                  ->orWhere('prenom', 'like', '%'.$request->search.'%')
                  ->orWhere('matricule', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('classe')) {
            $query->where('classe_id', $request->classe);
        }

        $eleves = $query->paginate(10)->withQueryString();
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('eleves.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:eleves',
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'genre' => 'required|in:masculin,feminin',
            'classe_id' => 'nullable|exists:classes,id',
            'parent_nom' => 'nullable|string|max:255',
            'parent_relation' => 'nullable|string|max:255',
            'parent_telephone' => 'nullable|string|max:20',
            'date_inscription' => 'required|date',
            'statut' => 'required|in:actif,inactif',
        ]);

        Eleve::create($validated);

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès.');
    }

    public function show(Eleve $eleve)
    {
        $eleve->load('classe');
        return view('eleves.show', compact('eleve'));
    }

    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    public function update(Request $request, Eleve $eleve)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:eleves,matricule,'.$eleve->id,
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'genre' => 'required|in:masculin,feminin',
            'classe_id' => 'nullable|exists:classes,id',
            'parent_nom' => 'nullable|string|max:255',
            'parent_relation' => 'nullable|string|max:255',
            'parent_telephone' => 'nullable|string|max:20',
            'date_inscription' => 'required|date',
            'statut' => 'required|in:actif,inactif',
        ]);

        $eleve->update($validated);

        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour avec succès.');
    }

    public function destroy(Eleve $eleve)
    {
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé avec succès.');
    }
}