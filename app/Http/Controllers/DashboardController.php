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
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $role = $user->role ?? 'unknown';
        $alerts = []; // Initialize here to be safe for all paths
        
        $stats = [
            'eleves_count' => Eleve::count(),
            'profs_count' => User::where('role', 'enseignant')->count(),
            'paiements_total' => Paiement::sum('montant_paye'),
            'paiements_total_formatted' => number_format(Paiement::sum('montant_paye'), 0, ',', ' '),
            'paiements_du_mois' => Paiement::whereMonth('date_paiement', now()->month)->sum('montant_paye'),
            'classes_count' => \App\Models\Classe::count(),
            'notes_count' => Note::count(),
            'trimestres_count' => 3, // Assuming 3 trimestres
            'filles_count' => Eleve::where('genre', 'Féminin')->count(),
            'garcons_count' => Eleve::where('genre', 'Masculin')->count(),
            'presence_rate' => Presence::count() > 0 ? round((Presence::where('statut', 'present')->count() / Presence::count()) * 100) : 0,
            'moyenne_generale' => round(Note::avg('note'), 2) ?: '0.00',
            // Default personal stats to avoid view errors
            'personal_moyenne' => '0.00',
            'personal_absences' => 0,
            'personal_presence_rate' => 0,
            
            // Chart Data
            'gender_distribution' => [
                'labels' => ['Garçons', 'Filles'],
                'data' => [
                    Eleve::where('genre', 'Masculin')->count(),
                    Eleve::where('genre', 'Féminin')->count()
                ]
            ],
            'monthly_payments' => [
                'labels' => collect(range(1, 12))->map(fn($m) => now()->month($m)->translatedFormat('M')),
                'data' => collect(range(1, 12))->map(fn($m) => Paiement::whereMonth('date_paiement', $m)->whereYear('date_paiement', now()->year)->sum('montant_paye'))
            ],
            'top_classes' => \App\Models\Classe::withCount('eleves')->orderBy('eleves_count', 'desc')->limit(5)->get()->map(fn($c) => ['label' => $c->nom, 'count' => $c->eleves_count])
        ];

        // Événements à venir
        $evenements = \App\Models\Evenement::where('date_debut', '>=', now())
            ->orderBy('date_debut', 'asc')
            ->limit(3)
            ->get();

        // Inscriptions récentes
        $recent_students = Eleve::with('classe')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Logic for Student Dashboard
        if ($role === 'eleve') {
            $eleve = Eleve::where('user_id', auth()->id())->first();
            
            if ($eleve) {
                $stats['personal_moyenne'] = round(Note::where('eleve_id', $eleve->id)->avg('note'), 2) ?: '0.00';
                $stats['personal_absences'] = Presence::where('eleve_id', $eleve->id)->where('statut', 'absent')->count();
                $stats['personal_presence_rate'] = Presence::where('eleve_id', $eleve->id)->count() > 0 
                    ? round((Presence::where('eleve_id', $eleve->id)->where('statut', 'present')->count() / Presence::where('eleve_id', $eleve->id)->count()) * 100) 
                    : 100;
                
                $recent_notes = Note::where('eleve_id', $eleve->id)->with('matiere')->orderBy('created_at', 'desc')->limit(5)->get();
                
                return view("Dashboard.eleve.index", compact('stats', 'eleve', 'recent_notes', 'evenements', 'alerts'));
            } else {
                // Si l'utilisateur est un élève mais n'a pas de profil lié
                $eleve = new Eleve(['nom' => $user->name, 'matricule' => 'N/A']);
                $recent_notes = collect();
                return view("Dashboard.eleve.index", compact('stats', 'eleve', 'recent_notes', 'evenements', 'alerts'))
                    ->with('warning', 'Votre compte n\'est pas encore lié à un profil élève.');
            }
        }

        // Logic for Parent Dashboard
        if ($role === 'parent') {
            $parentProfile = \App\Models\Parents::where('user_id', $user->id)->first();
            
            if ($parentProfile) {
                // Récupérer tous les enfants de ce parent
                $enfants = Eleve::where('parent_id', $parentProfile->id)
                    ->with(['classe', 'notes', 'presences'])
                    ->get();
                
                // Calculer les statistiques pour chaque enfant
                $enfants_stats = $enfants->map(function($enfant) {
                    $derniere_note = Note::where('eleve_id', $enfant->id)
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    $total_presences = Presence::where('eleve_id', $enfant->id)->count();
                    $presences_count = Presence::where('eleve_id', $enfant->id)
                        ->where('statut', 'present')
                        ->count();
                    
                    $taux_presence = $total_presences > 0 
                        ? round(($presences_count / $total_presences) * 100) 
                        : 0;
                    
                    return [
                        'eleve' => $enfant,
                        'derniere_note' => $derniere_note,
                        'taux_presence' => $taux_presence,
                        'moyenne' => round(Note::where('eleve_id', $enfant->id)->avg('note'), 2) ?: '0.00'
                    ];
                });
                
                return view("Dashboard.parent.index", compact('enfants_stats', 'stats', 'evenements', 'alerts'));
            } else {
                // Parent sans profil lié
                $enfants_stats = collect();
                return view("Dashboard.parent.index", compact('enfants_stats', 'stats', 'evenements', 'alerts'))
                    ->with('warning', 'Votre compte parent n\'est pas encore configuré.');
            }
        }

        // Logic for Teacher Dashboard
        if ($role === 'enseignant') {
            $enseignant = \App\Models\Enseignant::where('user_id', $user->id)->first();
            
            if ($enseignant) {
                // Récupérer les classes assignées à cet enseignant
                $mes_classes = $enseignant->classes()->with('eleves')->get();
                
                // Calculer les statistiques
                $total_eleves = $mes_classes->sum(function($classe) {
                    return $classe->eleves->count();
                });
                
                $total_notes = Note::whereIn('eleve_id', function($query) use ($mes_classes) {
                    $query->select('id')
                        ->from('eleves')
                        ->whereIn('classe_id', $mes_classes->pluck('id'));
                })->count();
                
                // Activités récentes (dernières notes saisies)
                $activites_recentes = Note::whereIn('eleve_id', function($query) use ($mes_classes) {
                    $query->select('id')
                        ->from('eleves')
                        ->whereIn('classe_id', $mes_classes->pluck('id'));
                })
                ->with(['eleve.classe'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
                
                $teacher_stats = [
                    'classes_count' => $mes_classes->count(),
                    'eleves_count' => $total_eleves,
                    'notes_count' => $total_notes,
                ];
                
                return view("Dashboard.enseignant.index", compact('mes_classes', 'teacher_stats', 'activites_recentes', 'stats', 'evenements', 'alerts'));
            } else {
                // Enseignant sans profil lié
                $mes_classes = collect();
                $teacher_stats = ['classes_count' => 0, 'eleves_count' => 0, 'notes_count' => 0];
                $activites_recentes = collect();
                return view("Dashboard.enseignant.index", compact('mes_classes', 'teacher_stats', 'activites_recentes', 'stats', 'evenements', 'alerts'))
                    ->with('warning', 'Votre compte enseignant n\'est pas encore configuré.');
            }
        }

        // AI Alerts Logic (Existing global logic for Admin/Staff)
        
        // 1. Détection des chutes de moyennes
        $failingStudents = DB::table('notes')
            ->select('eleve_id', DB::raw('AVG(note) as average'))
            ->groupBy('eleve_id')
            ->having('average', '<', 10)
            ->limit(3)
            ->get();

        foreach($failingStudents as $fail) {
            $eleve = Eleve::find($fail->eleve_id);
            if ($eleve) {
                $alerts[] = [
                    'type' => 'danger',
                    'title' => 'Alerte Performance',
                    'message' => "Moyenne critique pour {$eleve->nom} ({$fail->average}/20). Un suivi est recommandé.",
                    'student_id' => $eleve->id,
                    'student_name' => $eleve->nom . ' ' . $eleve->prenom,
                    'action_url' => route('eleves.show', $eleve->id)
                ];
            }
        }

        // 2. Alerte Paiements en attente (Paiements avec montant_restant > 0)
        $pendingPaymentsCount = Paiement::where('montant_restant', '>', 0)->count();
        if ($pendingPaymentsCount > 0) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Suivi Financier',
                'message' => "{$pendingPaymentsCount} paiements sont en attente de régularisation.",
                'action_url' => route('paiements.index')
            ];
        }

        if (in_array($role, ['admin', 'secretaire'])) {
            return view("Dashboard.index", compact('stats', 'alerts', 'recent_students', 'evenements'));
        }
        
        $view = "Dashboard.{$role}.index";
        if (!view()->exists($view)) {
            $view = "Dashboard.index";
        }

        return view($view, compact('stats', 'alerts', 'recent_students', 'evenements'));
    }
}