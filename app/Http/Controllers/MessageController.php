<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // Récupérer les conversations (groupées par correspondant)
        // C'est une logique simplifiée : on liste tous les messages où l'utilisateur est impliqué
        $messages = \App\Models\Message::where('expediteur_id', $userId)
                        ->orWhere('destinataire_id', $userId)
                        ->with(['expediteur', 'destinataire'])
                        ->latest()
                        ->get()
                        ->groupBy(function($msg) use ($userId) {
                            return $msg->expediteur_id == $userId ? $msg->destinataire_id : $msg->expediteur_id;
                        });

        // Récupérer les destinataires possibles (ex: pour le modal "Nouveau message")
        // Pour l'instant on récupère tout le monde sauf soi-même
        $users = \App\Models\User::where('id', '!=', $userId)->orderBy('name')->get();

        return view('messages.index', compact('messages', 'users'));
    }

    // Helper pour créer une nouvelle conversation
    public function create() 
    {
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();
        return view('messages.create', compact('users'));
    }

    public function show($userId)
    {
        $myId = auth()->id();
        $correspondant = \App\Models\User::findOrFail($userId);

        $conversation = \App\Models\Message::where(function($q) use ($myId, $userId) {
            $q->where('expediteur_id', $myId)->where('destinataire_id', $userId);
        })->orWhere(function($q) use ($myId, $userId) {
            $q->where('expediteur_id', $userId)->where('destinataire_id', $myId);
        })->orderBy('created_at', 'asc')->get();

        // Marquer comme lu
        \App\Models\Message::where('expediteur_id', $userId)
            ->where('destinataire_id', $myId)
            ->whereNull('lu_a')
            ->update(['lu_a' => now()]);

        return view('messages.show', compact('conversation', 'correspondant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destinataire_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
        ]);

        \App\Models\Message::create([
            'expediteur_id' => auth()->id(),
            'destinataire_id' => $request->destinataire_id,
            'contenu' => $request->contenu,
        ]);

        return back();
    }
}
