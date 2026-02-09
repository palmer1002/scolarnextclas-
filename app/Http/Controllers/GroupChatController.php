<?php

namespace App\Http\Controllers;

use App\Models\GroupMessage;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{
    /**
     * Afficher la page de discussion générale
     */
    public function index()
    {
        // Récupérer les 100 derniers messages
        $messages = GroupMessage::with('user')
            ->latest()
            ->take(100)
            ->get()
            ->reverse()
            ->values();

        return view('group-chat.index', compact('messages'));
    }

    /**
     * Envoyer un nouveau message
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message = GroupMessage::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Charger l'utilisateur pour le retour
        $message->load('user');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'html' => view('group-chat.partials.message', compact('message'))->render()
            ]);
        }

        return back()->with('success', 'Message envoyé');
    }

    /**
     * Récupérer les nouveaux messages (pour l'auto-refresh)
     */
    public function getNewMessages(Request $request)
    {
        $lastId = $request->input('last_id', 0);

        $messages = GroupMessage::with('user')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        $html = '';
        foreach ($messages as $message) {
            $html .= view('group-chat.partials.message', compact('message'))->render();
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'html' => $html,
            'count' => $messages->count()
        ]);
    }

    /**
     * Supprimer un message (seulement son propre message)
     */
    public function destroy($id)
    {
        $message = GroupMessage::findOrFail($id);

        // Vérifier que l'utilisateur est le propriétaire ou admin
        if ($message->user_id !== auth()->id() && !auth()->user()->hasRole('admin')) {
            return back()->with('error', 'Vous ne pouvez pas supprimer ce message');
        }

        $message->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Message supprimé');
    }
}
