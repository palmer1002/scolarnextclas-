<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = Parents::with(['user', 'students'])->paginate(10);
        return view('Parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = \App\Models\Eleve::all(); 
        return view('Parents.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone'   => 'required|string|max:20',
            'email'       => 'nullable|email|unique:parents,email',
            'adresse'     => 'nullable|string',
            'profession'  => 'nullable|string',
            'relation'    => 'required|string',
            'statut'      => 'required|in:active,inactive',
            'notes'       => 'nullable|string',
            'students'    => 'nullable|array',
            'students.*'  => 'exists:eleves,id',
        ]);

        // Create User account
        $user = User::create([
            'name' => $validated['nom_complet'],
            'email' => $validated['email'] ?? 'parent'.time().'@school.com',
            'password' => Hash::make($request->password ?? 'password'), 
            'role' => 'parent',
        ]);

        $parent = Parents::create([
            'user_id' => $user->id,
            'nom_complet' => $validated['nom_complet'],
            'telephone' => $validated['telephone'],
            'email' => $validated['email'],
            'adresse' => $validated['adresse'],
            'profession' => $validated['profession'],
            'relation' => $validated['relation'],
            'statut' => $validated['statut'],
            'notes' => $validated['notes'],
        ]);

        if (!empty($validated['students'])) {
            \App\Models\Eleve::whereIn('id', $validated['students'])->update(['parent_id' => $parent->id]);
        }

        return redirect()->route('parents.index')
            ->with('success', 'Parent ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Parents $parents)
    {
        $parents->load('students');
        return view('Parents.show', ['parent' => $parents]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parents $parents)
    {
        $students = \App\Models\Eleve::all();
        return view('Parents.edit', ['parent' => $parents, 'students' => $students]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parents $parents)
    {
        $validated = $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone'   => 'required|string|max:20',
            'email'       => [
                'nullable',
                'email',
                \Illuminate\Validation\Rule::unique('parents')->ignore($parents->id),
            ],
            'adresse'     => 'nullable|string',
            'profession'  => 'nullable|string',
            'relation'    => 'required|string',
            'statut'      => 'required|in:active,inactive',
            'notes'       => 'nullable|string',
            'students'    => 'nullable|array',
            'students.*'  => 'exists:eleves,id',
        ]);

        $parents->update($validated);

        if ($parents->user) {
            $parents->user->update([
                'name' => $validated['nom_complet'],
                'email' => $validated['email'] ?? $parents->user->email,
            ]);
        }

        // Handle students update. First detach all (set parent_id null) then attach new.
        \App\Models\Eleve::where('parent_id', $parents->id)->update(['parent_id' => null]);
        
        if (!empty($validated['students'])) {
            \App\Models\Eleve::whereIn('id', $validated['students'])->update(['parent_id' => $parents->id]);
        }

        return redirect()->route('parents.index')
            ->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parents $parents)
    {
        if ($parents->user) {
            $parents->user->delete();
        }
        $parents->delete();

        return redirect()->route('parents.index')
            ->with('success', 'Parent supprimé avec succès.');
    }

    public function profile()
    {
        $parent = Parents::where('user_id', auth()->id())->with('students')->first();
        if (!$parent) {
            return redirect()->route('dashboard')->with('error', 'Profil parent non trouvé.');
        }
        return view('Parents.show', compact('parent'));
    }
}