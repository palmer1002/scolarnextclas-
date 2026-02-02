<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Vérifier si l'email existe
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'Aucun compte n\'existe avec cette adresse email.',
            ])->onlyInput('email');
        }

        // Vérifier le mot de passe
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'Le mot de passe est incorrect.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        
        // Redirect based on user role
        $user = Auth::user();
        
        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard.admin');
            case 'enseignant':
                return redirect()->route('dashboard.enseignant');
            case 'parent':
                return redirect()->route('dashboard.parent');
            case 'eleve':
                return redirect()->route('dashboard.eleve');
            default:
                return redirect()->route('dashboard');
        }
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}