<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            $user = Auth::user();
            
            // Check if email verification is required and if user has verified their email
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended(route('dashboard'));
                case 'enseignant':
                    return redirect()->intended(route('enseignants.index'));
                case 'parent':
                    return redirect()->intended(route('parents.index'));
                case 'eleve':
                    return redirect()->intended(route('eleves.index'));
                default:
                    return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ])->onlyInput('email');
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    // Afficher la notice de vérification d'email
    public function showVerificationNotice()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }
        
        return view('auth.verify');
    }
    
    // Vérifier l'email
    public function verify(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'hash' => 'required'
        ]);
        
        $user = Auth::user();
        
        if ($user->id != $request->id || !URL::hasValidSignature($request)) {
            return redirect('/login')->with('error', 'Le lien de vérification est invalide.');
        }
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'))->with('status', 'Votre email est déjà vérifié.');
        }
        
        $user->markEmailAsVerified();
        
        return redirect()->intended(route('dashboard'))->with('status', 'Votre email a été vérifié avec succès!');
    }
    
    // Renvoyer l'email de vérification
    public function resend(Request $request)
    {
        $user = Auth::user();
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }
        
        $user->sendEmailVerificationNotification();
        
        return back()->with('status', 'Le lien de vérification a été envoyé!');
    }
}