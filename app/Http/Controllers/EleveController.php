<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $query = Eleve::with('classe');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->search.'%')
                  ->orWhere('prenom', 'like', '%'.$request->search.'%')
                  ->orWhere('matricule', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('classe')) {
            $query->where('classe_id', $request->classe);
        }

        $eleves = $query->paginate(10)->withQueryString();
        $classes = Classe::all();

        return view('eleves.index', compact('eleves', 'classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('eleves.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Matricule généré automatiquement
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'genre' => 'required|in:masculin,feminin',
            'classe_id' => 'required|exists:classes,id',
            'parent_nom' => 'nullable|string|max:255',
            'parent_relation' => 'nullable|string|max:255',
            'parent_telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'date_inscription' => 'required|date',
            'statut' => 'required|in:actif,inactif,gradué,abandon',
            'email' => 'nullable|email|unique:eleves,email',
            'adresse' => 'nullable|string',
        ]);

        // Génération automatique du matricule: SNC + Année + Séquence (ex: SNC2026001)
        $year = '2026';
        $prefix = 'SNC' . $year;
        
        // Trouver le dernier matricule de l'année en cours
        $lastEleve = Eleve::where('matricule', 'LIKE', $prefix . '%')
                          ->orderByRaw('LENGTH(matricule) DESC') // Pour gérer proprement les changements de longueur (ex: 999 vs 1000)
                          ->orderBy('matricule', 'desc')
                          ->first();

        if ($lastEleve) {
            // Extraire la séquence (les chiffres après SNC2026)
            $lastSequence = intval(substr($lastEleve->matricule, strlen($prefix)));
            $newSequence = $lastSequence + 1;
        } else {
            $newSequence = 1;
        }

        // Formater sur 3 chiffres min (ex: 001, 099, 100)
        $validated['matricule'] = $prefix . str_pad($newSequence, 3, '0', STR_PAD_LEFT);

        // Create User record
        $user = User::create([
            'name' => $validated['prenom'] . ' ' . $validated['nom'],
            'email' => $validated['email'] ?? strtolower($validated['matricule']) . '@school.com',
            'password' => Hash::make($request->password ?? 'password'),
            'role' => 'eleve',
        ]);

        $validated['user_id'] = $user->id;

        Eleve::create($validated);

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès. Matricule : ' . $validated['matricule'] . ' - Compte créé.');
    }

    public function show(Eleve $eleve)
    {
        $eleve->load('classe');
        return view('eleves.show', compact('eleve'));
    }

    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    public function update(Request $request, Eleve $eleve)
    {
        $validated = $request->validate([
            'matricule' => 'required|unique:eleves,matricule,'.$eleve->id,
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'genre' => 'required|in:masculin,feminin',
            'classe_id' => 'nullable|exists:classes,id',
            'parent_nom' => 'nullable|string|max:255',
            'parent_relation' => 'nullable|string|max:255',
            'parent_telephone' => 'nullable|string|max:20',
            'date_naissance' => 'required|date',
            'date_inscription' => 'required|date',
            'statut' => 'required|in:actif,inactif,gradué,abandon',
            'email' => 'nullable|email|unique:eleves,email,'.$eleve->id,
            'adresse' => 'nullable|string',
        ]);

        $eleve->update($validated);

        if ($eleve->user) {
            $eleve->user->update([
                'name' => $validated['prenom'] . ' ' . $validated['nom'],
                'email' => $request->email ?? $eleve->user->email,
            ]);
        }

        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour avec succès.');
    }

    public function destroy(Eleve $eleve)
    {
        if ($eleve->user) {
            $eleve->user->delete();
        }
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé avec succès.');
    }

    public function profile()
    {
        $eleve = Eleve::where('user_id', auth()->id())->with('classe')->first();
        if (!$eleve) {
            return redirect()->route('dashboard')->with('error', 'Profil élève non trouvé.');
        }
        return view('eleves.show', compact('eleve'));
    }
}