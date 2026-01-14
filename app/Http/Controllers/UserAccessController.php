<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAccessController extends Controller
{
    /**
     * Display a listing of administrative users.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Only fetch users that belong to administration
        // Note: Currently roles are stored as a string. We might want to expand these roles.
        // For now, it seems 'admin' is the catch-all for staff in web.php.
        // We will filter out parents and eleves. Administrative staff includes admin, secretaire, and enseignants (accounts).
        $query = User::whereNotIn('role', ['parent', 'eleve']);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = ['admin', 'secretaire', 'enseignant'];
        
        return view('Utilisateurs.index', compact('users', 'roles'));
    }
    
    /**
     * Show the form for creating a new administrative user.
     */
    public function create()
    {
        $roles = ['admin', 'secretaire', 'enseignant']; 
        return view('Utilisateurs.create', compact('roles'));
    }
    
    /**
     * Store a newly created administrative user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'role' => ['required', Rule::in(['admin', 'secretaire', 'enseignant'])],
        ]);
        
        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => 'active',
            ]);
            
            return redirect()->route('utilisateurs.index')
                ->with('success', 'Compte administratif créé avec succès !');
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
        $user = User::whereNotIn('role', ['parent', 'eleve'])->findOrFail($id);
        return view('Utilisateurs.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::whereNotIn('role', ['parent', 'eleve'])->findOrFail($id);
        $roles = ['admin', 'secretaire', 'enseignant'];
        return view('Utilisateurs.edit', compact('user', 'roles'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::whereNotIn('role', ['parent', 'eleve'])->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => ['required', Rule::in(['admin', 'secretaire', 'enseignant'])],
        ]);
        
        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ]);
            
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|string|min:4|confirmed',
                ]);
                
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            
            return redirect()->route('utilisateurs.show', $user->id)
                ->with('success', 'Compte mis à jour avec succès !');
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
        $user = User::whereNotIn('role', ['parent', 'eleve'])->findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->route('utilisateurs.show', $id)->with('success', 'Utilisateur activé.');
    }

    /**
     * Deactivate a user account
     */
    public function deactivate($id)
    {
        $user = User::whereNotIn('role', ['parent', 'eleve'])->findOrFail($id);
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
            $user = User::whereNotIn('role', ['parent', 'eleve'])->findOrFail($id);
            
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