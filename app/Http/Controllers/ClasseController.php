<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('eleves')->get();
        return view('Classes.index', compact('classes'));
    }

    public function create()
    {
        return view('Classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'capacite_max' => 'required|integer|min:1',
            'annee_scolaire' => 'required|integer',
        ]);

        Classe::create($validated);

        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès.');
    }

    public function show(Classe $class)
    {
        $class->load(['eleves', 'enseignants']);
        return view('Classes.show', compact('class'));
    }

    public function edit(Classe $class)
    {
        return view('Classes.edit', compact('class'));
    }

    public function update(Request $request, Classe $class)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'capacite_max' => 'required|integer|min:1',
            'annee_scolaire' => 'required|integer',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    public function destroy(Classe $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
