<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\User;
use App\Models\Paiement;
use App\Models\Presence;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        
        $stats = [
            'eleves_count' => Eleve::count(),
            'profs_count' => User::where('role', 'enseignant')->count(),
            'paiements_total' => Paiement::sum('montant_paye'),
            'paiements_du_mois' => Paiement::whereMonth('date_paiement', now()->month)->sum('montant_paye'),
            'classes_count' => \App\Models\Classe::count(),
            'filles_count' => Eleve::where('genre', 'Féminin')->count(),
            'garcons_count' => Eleve::where('genre', 'Masculin')->count(),
            'presence_rate' => Presence::count() > 0 ? round((Presence::where('statut', 'present')->count() / Presence::count()) * 100) : 0,
        ];

        // AI Alerts Logic (Simple mock logic for MVP)
        // 1. Check for students with grade drop
        // 2. Check for students with high absence
        $alerts = [];
        
        // Example: Students with avg < 10
        // This is heavy query, in real app use caching or jobs
        $failingStudents = DB::table('notes')
            ->select('eleve_id', DB::raw('AVG(note) as average'))
            ->groupBy('eleve_id')
            ->having('average', '<', 10)
            ->limit(5)
            ->get();

        foreach($failingStudents as $fail) {
            $alerts[] = [
                'type' => 'warning',
                'message' => 'Moyenne faible détectée pour élève ID ' . $fail->eleve_id . ' (' . round($fail->average, 1) . '/20)'
            ];
        }

        return view("Dashboard.{$role}.index", compact('stats', 'alerts'));
    }
}