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
        $user = Auth::user();
        $query = Presence::with(['eleve', 'classe']);

        // Si Parent : voir seulement ses enfants
        if ($user->role === 'parent') {
            $parent = \App\Models\Parents::where('user_id', $user->id)->first();
            if ($parent) {
                $enfantIds = $parent->students()->pluck('id');
                $query->whereIn('eleve_id', $enfantIds);
            } else {
                // Cas de sécurité si le compte parent n'est pas lié correctement
                $query->where('id', -1); 
            }
        }
        // Si Élève : voir seulement ses présences
        elseif ($user->role === 'eleve') {
            $eleve = \App\Models\Eleve::where('user_id', $user->id)->first();
            if ($eleve) {
                $query->where('eleve_id', $eleve->id);
            }
        }

        $presences = $query->orderBy('date', 'desc')->paginate(20);

        // Pour le modal d'ajout (visible seulement par admin/enseignant normalement)
        $eleves = Eleve::orderBy('nom')->get();
        
        return view('Presences.index', compact('presences', 'eleves'));
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
