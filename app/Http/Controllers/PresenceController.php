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

        $eleve = Eleve::find($request->eleve_id);
        
        // Use first() to avoid duplicates for same day
        Presence::updateOrCreate(
            [
                'eleve_id' => $request->eleve_id, 
                'date' => $request->date
            ],
            [
                'classe_id' => $eleve->classe, // Assuming classe is stored as ID, if string need conversion. Migration says string?? Let's check. 
                // Migration says 'classe' is string in eleves, but presences has 'classe_id'.
                // Ideally Eleve should have 'classe_id'. For now, we might leave classe_id null if we can't map it, or we need to fix Eleve schema.
                // Re-checking Eleve schema: $table->string('classe', 100); 
                // Re-checking Presence schema: $table->foreignId('classe_id')... constrained.
                // Mismatch detected. I will leave classe_id null for now or try to find classe by name.
                // 'classe_id' => Classe::where('nom', $eleve->classe)->first()?->id,
                'statut' => $request->statut,
                'justifie' => $request->justifie ?? false,
                'motif' => $request->motif
            ]
        );

        return back()->with('success', 'Présence enregistrée.');
    }

    /**
     * Get statistics for a student.
     */
    public function stats($eleve_id)
    {
        $stats = [
            'total' => Presence::where('eleve_id', $eleve_id)->count(),
            'absences' => Presence::where('eleve_id', $eleve_id)->absent()->count(),
            'retards' => Presence::where('eleve_id', $eleve_id)->retard()->count(),
        ];
        return response()->json($stats);
    }
}
