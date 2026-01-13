<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenementController extends Controller
{
    public function index()
    {
        $events = Evenement::where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->get();
        return view('Evenements.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'type' => 'required'
        ]);

        $validated['cree_par'] = Auth::id();

        Evenement::create($validated);

        return back()->with('success', 'Événement créé.');
    }
}
