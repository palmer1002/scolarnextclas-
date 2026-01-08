<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index()
    {
        // Only accessible by enseignants
        return view('Enseignants.index');
    }

    public function create()
    {
        // Only accessible by enseignants
        return view('Enseignants.create');
    }

    public function store(Request $request)
    {
        // Store logic for enseignants
        return redirect()->route('enseignants.index');
    }

    public function show($enseignant)
    {
        // Only accessible by enseignants
        return view('Enseignants.show', ['enseignant' => $enseignant]);
    }

    public function edit($enseignant)
    {
        // Only accessible by enseignants
        return view('Enseignants.edit', ['enseignant' => $enseignant]);
    }

    public function update(Request $request, $enseignant)
    {
        // Update logic for enseignants
        return redirect()->route('enseignants.index');
    }

    public function destroy($enseignant)
    {
        // Delete logic for enseignants
        return redirect()->route('enseignants.index');
    }
}
