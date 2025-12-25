<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    /**
     * Affiche la liste des élèves avec recherche et filtrage.
     */
    public function index(Request $request)
    {
        $query = Eleve::query();

        if ($request->filled('search')) {
            $query->where('nom_complet', 'like', '%' . $request->search . '%')
                  ->orWhere('matricule', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('classe')) {
            $query->where('classe_id', $request->classe);
        }

        $eleves = $query->paginate(10);
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes'));
    }

    /**
     * Formulaire de création d’un élève.
     */
    public function create()
    {
        $classes = Classe::all();
        return view('eleves.create', compact('classes'));
    }

    /**
     * Enregistre un nouvel élève.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:eleves',
            'nom_complet' => 'required|string|max:255',
            'genre' => 'required|string',
            'classe_id' => 'nullable|exists:classes,id',
            'parent_nom' => 'nullable|string|max:255',
            'parent_relation' => 'nullable|string|max:255',
            'parent_telephone' => 'nullable|string|max:20',
            'date_inscription' => 'required|date',
            'statut' => 'required|string',
        ]);

        Eleve::create($validated);

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un élève.
     */
    public function show(Eleve $eleve)
    {
        return view('eleves.show', compact('eleve'));
    }

    /**
     * Formulaire d'édition d'un élève.
     */
    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    /**
     * Met à jour un élève.
     */
    public function update(Request $request, Eleve $eleve)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:eleves,matricule,' . $eleve->id,
            'nom_complet' => 'required|string|max:255',
            'genre' => 'required|string',
            'classe_id' => 'nullable|exists:classes,id',
            'parent_nom' => 'nullable|string|max:255',
            'parent_relation' => 'nullable|string|max:255',
            'parent_telephone' => 'nullable|string|max:255',
            'date_inscription' => 'required|date',
            'statut' => 'required|string',
        ]);

        $eleve->update($validated);

        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour avec succès.');
    }

    /**
     * Supprime un élève.
     */
    public function destroy(Eleve $eleve)
    {
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé avec succès.');
    }
}