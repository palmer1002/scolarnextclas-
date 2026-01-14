<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presences = Presence::with(['eleve', 'classe'])
            ->orderBy('date', 'desc')
            ->paginate(20);
        
        return view('Presences.index', compact('presences'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'date' => 'required|date',
            'statut' => 'required|in:present,absent,retard',
        ]);

        $eleve = Eleve::findOrFail($request->eleve_id);
        
        Presence::updateOrCreate(
            [
                'eleve_id' => $request->eleve_id, 
                'date' => $request->date
            ],
            [
                'classe_id' => $eleve->classe_id,
                'statut' => $request->statut,
                'justifie' => $request->justifie ?? false,
                'motif' => $request->motif
            ]
        );

        return back()->with('success', 'Présence enregistrée.');
    }

    public function storeForEleve(Request $request, $eleve_id)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $eleve = Eleve::findOrFail($eleve_id);
        
        Presence::updateOrCreate(
            [
                'eleve_id' => $eleve_id, 
                'date' => $request->date
            ],
            [
                'classe_id' => $eleve->classe_id,
                'statut' => $request->present ? 'present' : 'absent',
            ]
        );

        return back()->with('success', 'Présence enregistrée avec succès.');
    }

    /**
     * Get statistics for a student.
     */
    public function stats($eleve_id)
    {
        $eleve = Eleve::findOrFail($eleve_id);
        return view('Eleves.presence', compact('eleve'));
    }
}
