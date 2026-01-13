<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlerteController extends Controller
{
    public function index()
    {
        $alertes = Alerte::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('Alertes.index', compact('alertes'));
    }

    public function markAsRead(Alerte $alerte)
    {
        if ($alerte->user_id !== Auth::id()) {
            abort(403);
        }

        $alerte->update(['lu' => true]);

        return back()->with('success', 'Alerte marquée comme lue.');
    }
}
