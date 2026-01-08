<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;

class UserAccessController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        
        $query = User::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($role && $role !== 'all') {
            $query->where('role', $role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = ['admin', 'enseignant', 'parent', 'eleve'];
        
        return view('Utilisateurs.index', compact('users', 'roles'));
    }
    
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = ['admin', 'enseignant', 'parent', 'eleve'];
        return view('Utilisateurs.create', compact('roles'));
    }
    
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'enseignant', 'parent', 'eleve'])],
        ]);
        
        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);
            
            return redirect()->route('utilisateurs.index')
                ->with('success', 'Utilisateur créé avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('Utilisateurs.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'enseignant', 'parent', 'eleve'];
        return view('Utilisateurs.edit', compact('user', 'roles'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => ['required', Rule::in(['admin', 'enseignant', 'parent', 'eleve'])],
        ]);
        
        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);
            
            // If password is provided, update it
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|string|min:8|confirmed',
                ]);
                
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            
            return redirect()->route('utilisateurs.show', $user->id)
                ->with('success', 'Utilisateur mis à jour avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Activate a user account
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->route('utilisateurs.show', $id)->with('success', 'Utilisateur activé.');
    }

    /**
     * Deactivate a user account
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inactive';
        $user->save();

        return redirect()->route('utilisateurs.show', $id)->with('success', 'Utilisateur désactivé.');
    }
    
    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deleting the main admin user
            if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer le dernier administrateur.');
            }
            
            $user->delete();
            
            return redirect()->route('utilisateurs.index')
                ->with('success', 'Utilisateur supprimé avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}