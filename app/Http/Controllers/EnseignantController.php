<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::with('user')->paginate(10);
        return view('Enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('Enseignants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email|unique:enseignants,email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:Permanent,Vacataire',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create User
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make('password'), // Default password
                'role' => 'enseignant',
            ]);

            // 2. Create Enseignant Profile
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

            DB::commit();

            return redirect()->route('enseignants.index')->with('success', 'Enseignant ajouté avec succès. Compte utilisateur créé.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création de l\'enseignant: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Enseignant $enseignant)
    {
        return view('Enseignants.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        return view('Enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'email' => [
                'required', 
                'email', 
                Rule::unique('users', 'email')->ignore($enseignant->user_id),
                Rule::unique('enseignants', 'email')->ignore($enseignant->id)
            ],
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:Permanent,Vacataire',
        ]);

        DB::beginTransaction();

        try {
            // Update User if email/name changed
            if ($enseignant->user) {
                $enseignant->user->update([
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email' => $validated['email'],
                ]);
            }

            // Update Profile
            $enseignant->update($validated);

            DB::commit();
            return redirect()->route('enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur de mise à jour: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Enseignant $enseignant)
    {
        try {
            if ($enseignant->user) {
                $enseignant->user->delete(); // This typically also deletes enseignant via Cascade, but double check
            }
            $enseignant->delete();
            return redirect()->route('enseignants.index')->with('success', 'Enseignant supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur de suppression: ' . $e->getMessage());
        }
    }
}
