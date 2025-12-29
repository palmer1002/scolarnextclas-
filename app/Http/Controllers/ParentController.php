<?php

namespace App\Http\Controllers;

use App\Models\User; // Using User model with role
use Illuminate\Http\Request;

class ParentController extends Controller
{
    /**
     * Afficher la liste des parents.
     */
    public function index()
    {
        $parents = User::where('role', 'parent')->paginate(10);
        return view('parents.index', compact('parents'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('parents.create');
    }

    /**
     * Enregistrer un nouveau parent.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone'   => 'required|string|max:20',
            'email'       => 'nullable|email|unique:parents,email',
            'relation'    => 'required|string|max:50',
        ]);

        User::create(['name' => $request->nom_complet, 'email' => $request->email, 'password' => bcrypt('parent123'), 'role' => 'parent']);

        return redirect()->route('parents.index')
            ->with('success', 'Parent ajouté avec succès.');
    }

    /**
     * Afficher les détails d’un parent.
     */
    public function show($id)
    {
        $parent = User::where('role', 'parent')->findOrFail($id);
        return view('parents.show', compact('parent'));
    }

    /**
     * Afficher le formulaire d’édition.
     */
    public function edit($id)
    {
        $parent = User::where('role', 'parent')->findOrFail($id);
        return view('parents.edit', compact('parent'));
    }

    /**
     * Mettre à jour un parent.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone'   => 'required|string|max:20',
            'email'       => 'nullable|email|unique:parents,email,' . $id,
            'relation'    => 'required|string|max:50',
        ]);

        $parent = User::where('role', 'parent')->findOrFail($id);
        $parent->update(['name' => $request->nom_complet, 'email' => $request->email]);

        return redirect()->route('parents.index')
            ->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Supprimer un parent.
     */
    public function destroy($id)
    {
        $parent = User::where('role', 'parent')->findOrFail($id);
        $parent->delete();

        return redirect()->route('parents.index')
            ->with('success', 'Parent supprimé avec succès.');
    }
}