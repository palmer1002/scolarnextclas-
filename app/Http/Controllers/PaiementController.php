<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Eleve;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('eleve')->orderBy('created_at', 'desc')->paginate(20);
        return view('Paiements.index', compact('paiements'));
    }

    public function create()
    {
        $eleves = Eleve::all();
        return view('Paiements.create', compact('eleves'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'montant' => 'required|numeric',
            'type_paiement' => 'required',
            'date_paiement' => 'required|date'
        ]);

        Paiement::create($validated);

        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré.');
    }

    public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        return view('Paiements.show', compact('paiement'));
    }

    public function edit($id)
    {
        $paiement = Paiement::findOrFail($id);
        $eleves = Eleve::all();
        return view('Paiements.edit', compact('paiement', 'eleves'));
    }

    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->update($request->all());
        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour.');
    }
}