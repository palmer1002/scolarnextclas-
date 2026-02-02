<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index()
    {
        // Administrateurs : voient tout et peuvent gérer
        if (auth()->user()->role === 'admin') {
            $annonces = \App\Models\Annonce::with('auteur')->latest()->get();
            return view('annonces.index_admin', compact('annonces'));
        } 
        
        // Autres (Parents, Profs, Élèves) : voient seulement ce qui les concerne
        $role = auth()->user()->role;
        $annonces = \App\Models\Annonce::where(function($query) use ($role) {
            $query->where('cible', 'tous')
                  ->orWhere('cible', $role . 's'); // 'parents', 'enseignants', 'eleves'
        })->latest()->get();

        return view('annonces.index_user', compact('annonces'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'type' => 'required|in:info,urgent,event',
            'cible' => 'required|in:tous,enseignants,parents,eleves'
        ]);

        \App\Models\Annonce::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'type' => $request->type,
            'cible' => $request->cible,
            'user_id' => auth()->id()
        ]);

        return back()->with('success', 'Annonce publiée avec succès !');
    }

    public function destroy(\App\Models\Annonce $annonce)
    {
        $annonce->delete();
        return back()->with('success', 'Annonce supprimée.');
    }
}
