<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Note;
use App\Models\StatistiqueCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Récupérer toutes les données du dashboard
     */
    public function getDashboardData()
    {
        // Utiliser le cache pour améliorer les performances
        $data = Cache::remember('dashboard_data', 300, function () { 
            $stats = $this->calculateStats();
            $recentEleves = $this->getRecentEleves();
            $alertes = $this->detectAlertes();
            
            return [
                'stats' => $stats,
                'recentEleves' => $recentEleves,
                'alertes' => $alertes,
                'lastUpdated' => now()->toDateTimeString()
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Calculer les statistiques
     */
    private function calculateStats()
    {
        return [
            'total_eleves' => Eleve::count(),
            'total_notes' => Note::count(),
            'moyenne_generale' => round(Note::avg('note') ?? 0, 2),
            'alertes_actives' => $this->countAlertes()
        ];
    }

    /**
     * Récupérer les élèves récents
     */
    private function getRecentEleves($limit = 10)
    {
        return Eleve::orderBy('date_inscription', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($eleve) {
                return [
                    'matricule' => $eleve->matricule,
                    'nom_complet' => $eleve->nom_complet,
                    'classe' => $eleve->classe,
                    'genre' => $eleve->genre,
                    'date_inscription' => $eleve->date_inscription->format('d/m/Y'),
                    'contact_parent' => $eleve->contact_parent
                ];
            });
    }

    /**
     * Détecter les alertes (chutes/améliorations > 20%)
     */
    private function detectAlertes()
    {
        $alertes = [];
        
        // Récupérer les moyennes par trimestre
        $moyennes = Note::select([
                'eleve_id',
                'trimestre',
                DB::raw('AVG(note) as moyenne')
            ])
            ->groupBy('eleve_id', 'trimestre')
            ->orderBy('eleve_id')
            ->orderBy('trimestre')
            ->get()
            ->groupBy('eleve_id');
        
        foreach ($moyennes as $eleveId => $trimestres) {
            if ($trimestres->count() >= 2) {
                $t1 = $trimestres->firstWhere('trimestre', 1);
                $t2 = $trimestres->firstWhere('trimestre', 2);
                
                if ($t1 && $t2) {
                    $variation = (($t2->moyenne - $t1->moyenne) / $t1->moyenne) * 100;
                    
                    if (abs($variation) > 20) {
                        $eleve = Eleve::find($eleveId);
                        
                        $alertes[] = [
                            'nom' => $eleve->nom_complet,
                            'matricule' => $eleve->matricule,
                            't1' => round($t1->moyenne, 2),
                            't2' => round($t2->moyenne, 2),
                            'variation' => round($variation, 1),
                            'contact' => $eleve->contact_parent,
                            'type' => $variation > 0 ? 'positive' : 'negative'
                        ];
                    }
                }
            }
        }
        
        return $alertes;
    }

    /**
     * Compter le nombre d'alertes
     */
    private function countAlertes()
    {
        return count($this->detectAlertes());
    }

    /**
     * Ajouter un nouvel élève
     */
    public function addEleve(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:eleves',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'classe' => 'required|string|max:50',
            'genre' => 'required|in:Masculin,Féminin',
            'contact_parent' => 'nullable|string|max:20'
        ]);
        
        $eleve = Eleve::create([
            'matricule' => $request->matricule,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'classe' => $request->classe,
            'genre' => $request->genre,
            'date_inscription' => now(),
            'contact_parent' => $request->contact_parent
        ]);
        
        // Invalider le cache
        Cache::forget('dashboard_data');
        
        return response()->json([
            'success' => true,
            'data' => $eleve,
            'message' => 'Élève ajouté avec succès'
        ], 201);
    }

    /**
     * Ajouter une note
     */
    public function addNote(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'trimestre' => 'required|in:1,2,3',
            'semestre' => 'required|in:1,2',
            'matiere' => 'required|string|max:100',
            'note' => 'required|numeric|min:0|max:20',
            'coefficient' => 'required|integer|min:1',
            'annee_scolaire' => 'required|string'
        ]);
        
        $note = Note::create($request->all());
        
        // Invalider le cache
        Cache::forget('dashboard_data');
        
        return response()->json([
            'success' => true,
            'data' => $note,
            'message' => 'Note ajoutée avec succès'
        ], 201);
    }
}