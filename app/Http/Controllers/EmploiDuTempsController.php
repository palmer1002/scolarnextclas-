<?php

namespace App\Http\Controllers;

use App\Models\EmploiDuTemps;
use App\Models\Classe;
use Illuminate\Http\Request;

class EmploiDuTempsController extends Controller
{
    public function index(Request $request)
    {
        $query = EmploiDuTemps::with(['classe', 'matiere', 'enseignant']);

        if ($request->has('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        $emplois = $query->orderBy('jour_semaine')->orderBy('heure_debut')->get();
        // Group by day for easier display
        $grouped = $emplois->groupBy('jour_semaine');

        return view('EmploisDuTemps.index', compact('grouped'));
    }

    public function store(Request $request)
    {
        // Admin only usually
        $validated = $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'jour_semaine' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        EmploiDuTemps::create($validated);

        return back()->with('success', 'Créneau ajouté.');
    }
}
