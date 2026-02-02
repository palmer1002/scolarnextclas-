<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enseignants = Enseignant::with(['classes', 'matieres'])->get();
        return view('Enseignants.index', compact('enseignants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        return view('Enseignants.create', compact('classes', 'matieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'subject' => 'nullable', // Keep for backward compatibility or description
            'email' => 'required|email|unique:enseignants,email',
            'phone' => 'nullable',
            'status' => 'required',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
            'matieres' => 'nullable|array',
            'matieres.*' => 'exists:matieres,id',
        ]);

        // Create User account for the teacher
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($request->password ?? 'password'), 
            'role' => 'enseignant',
        ]);

        $enseignant = Enseignant::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'subject' => $validated['subject'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $validated['status'],
        ]);

        if (isset($validated['classes'])) {
            $enseignant->classes()->sync($validated['classes']);
        }

        if (isset($validated['matieres'])) {
            $enseignant->matieres()->sync($validated['matieres']);
        }

        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant ajouté avec succès et compte utilisateur créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enseignant $enseignant)
    {
        $enseignant->load(['classes', 'matieres']);
        return view('Enseignants.show', compact('enseignant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enseignant $enseignant)
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignant->load(['classes', 'matieres']);
        return view('Enseignants.edit', compact('enseignant', 'classes', 'matieres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enseignant $enseignant)
    {
        $validated = $request->validate([
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'subject' => 'nullable',
            'email' => [
                'required',
                'email',
                Rule::unique('enseignants')->ignore($enseignant->id),
            ],
            'phone' => 'nullable',
            'status' => 'required',
            'classes' => 'nullable|array',
            'classes.*' => 'exists:classes,id',
            'matieres' => 'nullable|array',
            'matieres.*' => 'exists:matieres,id',
        ]);

        $enseignant->update([
            'title' => $validated['title'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'subject' => $validated['subject'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => $validated['status'],
        ]);

        if (isset($validated['classes'])) {
            \Illuminate\Support\Facades\Log::info('Updating classes for teacher ' . $enseignant->id, ['classes' => $validated['classes']]);
            $enseignant->classes()->sync($validated['classes']);
        } else {
            \Illuminate\Support\Facades\Log::info('Detaching classes for teacher ' . $enseignant->id);
            $enseignant->classes()->detach();
        }

        if (isset($validated['matieres'])) {
            $enseignant->matieres()->sync($validated['matieres']);
        } else {
            $enseignant->matieres()->detach();
        }

        // Update User email if changed
        if ($enseignant->user) {
            $enseignant->user->update([
                'email' => $validated['email'],
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            ]);
        }

        return redirect()->route('enseignants.index')
                         ->with('success', 'Informations de l\'enseignant mises à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enseignant $enseignant)
    {
        // Delete associated user account
        if ($enseignant->user) {
            $enseignant->user->delete();
        }
        
        $enseignant->delete();

        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant supprimé avec succès.');
    }

    public function profile()
    {
        $enseignant = Enseignant::where('user_id', auth()->id())->with(['classes', 'matieres'])->first();
        if (!$enseignant) {
            return redirect()->route('dashboard')->with('error', 'Profil enseignant non trouvé.');
        }
        return view('Enseignants.show', compact('enseignant'));
    }
}
