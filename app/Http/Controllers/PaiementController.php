<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    public function downloadReceipt($id)
    {
        $paiement = Paiement::with(['eleve' => function($query) {
            $query->with('classe');
        }])->findOrFail($id);
        
        $pdf = Pdf::loadView('Paiements.receipt_pdf', compact('paiement'));
        
        $filename = 'Reçu_' . ($paiement->numero_recu ?? $paiement->id) . '_' . str_replace(' ', '_', $paiement->eleve->nom) . '.pdf';
        
        return $pdf->download($filename);
    }
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
            'type_paiement' => 'required|string',
            'montant_total' => 'required|numeric|min:0',
            'montant_paye' => 'nullable|numeric|min:0',
            'mode_paiement' => 'required|string',
            'date_echeance' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['encaisser_par'] = auth()->id();
        $validated['date_paiement'] = now();
        
        // Initialiser le montant (requis par la migration comme champ distinct de montant_total parfois)
        $validated['montant'] = $validated['montant_total'];
        
        // Déterminer le statut initial si non fourni
        $montant_paye = $validated['montant_paye'] ?? 0;
        $montant_total = $validated['montant_total'];
        
        if ($montant_paye >= $montant_total) {
            $validated['statut'] = 'payé';
            $validated['montant_restant'] = 0;
        } elseif ($montant_paye > 0) {
            $validated['statut'] = 'partiel';
            $validated['montant_restant'] = $montant_total - $montant_paye;
        } else {
            $validated['statut'] = 'en_attente';
            $validated['montant_restant'] = $montant_total;
        }

        $validated['annee_scolaire'] = '2025-2026';
        Paiement::create($validated);

        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }

    public function show($id)
    {
        $paiement = Paiement::with('eleve')->findOrFail($id);
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
        
        $validated = $request->validate([
            'type_paiement' => 'required|string',
            'montant_total' => 'required|numeric|min:0',
            'montant_paye' => 'nullable|numeric|min:0',
            'statut' => 'required|string',
            'mode_paiement' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $validated['montant'] = $validated['montant_total'];
        $validated['montant_restant'] = $validated['montant_total'] - ($validated['montant_paye'] ?? 0);

        $validated['annee_scolaire'] = '2025-2026';
        $paiement->update($validated);
        
        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès.');
    }
}