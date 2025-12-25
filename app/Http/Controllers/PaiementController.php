<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Eleve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PaiementController extends Controller
{
    /**
     * Afficher la liste des paiements.
     */
    public function index(Request $request)
    {
        $query = Paiement::with(['eleve', 'user', 'encaisseur']);

        // Filtres
        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }

        if ($request->filled('type_paiement')) {
            $query->where('type_paiement', $request->type_paiement);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('annee_scolaire')) {
            $query->where('annee_scolaire', $request->annee_scolaire);
        }

        if ($request->filled('type_periode')) {
            $query->where('type_periode', $request->type_periode);
        }

        if ($request->filled('numero_periode')) {
            $query->where('numero_periode', $request->numero_periode);
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_paiement', [$request->date_debut, $request->date_fin]);
        }

        if ($request->filled('en_retard')) {
            $query->where('statut', 'en_attente')
                  ->where('date_echeance', '<', now());
        }

        if ($request->filled('is_recurrent')) {
            $query->where('is_recurrent', $request->is_recurrent);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_recu', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhereHas('eleve', function($q) use ($search) {
                      $q->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%")
                        ->orWhere('matricule', 'like', "%{$search}%");
                  });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination ou retour complet
        if ($request->has('per_page')) {
            $paiements = $query->paginate($request->per_page);
        } else {
            $paiements = $query->get();
        }

        // Statistiques
        $stats = Paiement::statistiques($request->eleve_id);

        return response()->json([
            'success' => true,
            'data' => $paiements,
            'statistiques' => $stats,
            'meta' => $request->has('per_page') ? [
                'total' => $paiements->total(),
                'per_page' => $paiements->perPage(),
                'current_page' => $paiements->currentPage(),
                'last_page' => $paiements->lastPage(),
            ] : null
        ]);
    }

    /**
     * Afficher les paiements d'un élève spécifique.
     */
    public function paiementsEleve($eleveId)
    {
        $eleve = Eleve::findOrFail($eleveId);
        
        $paiements = Paiement::with(['user', 'encaisseur'])
                            ->where('eleve_id', $eleveId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $stats = Paiement::statistiques($eleveId);

        return response()->json([
            'success' => true,
            'eleve' => $eleve,
            'data' => $paiements,
            'statistiques' => $stats
        ]);
    }

    /**
     * Afficher un paiement spécifique.
     */
    public function show($id)
    {
        $paiement = Paiement::with(['eleve', 'user', 'encaisseur'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $paiement
        ]);
    }

    /**
     * Créer un nouveau paiement.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eleve_id' => 'required|exists:eleves,id',
            'montant' => 'required|numeric|min:0',
            'montant_total' => 'nullable|numeric|min:0',
            'type_paiement' => 'required|in:Scolarité,Cantine,Transport,Fournitures,Activités,Assurance,Autre',
            'type_periode' => 'nullable|in:Trimestre,Semestre,Mois,Annuel',
            'numero_periode' => 'nullable|integer|min:1',
            'annee_scolaire' => 'nullable|string|max:20',
            'date_echeance' => 'nullable|date',
            'mode_paiement' => 'nullable|in:espèces,chèque,virement,carte_bancaire,mobile_money,autre',
            'statut' => 'nullable|in:brouillon,en_attente,partiel,payé,annulé,remboursé',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            
            // Si pas de montant_total, utiliser montant
            if (!isset($data['montant_total']) && isset($data['montant'])) {
                $data['montant_total'] = $data['montant'];
            }
            
            // Calculer montant_restant si montant_paye est fourni
            if (isset($data['montant_paye'])) {
                $data['montant_restant'] = $data['montant_total'] - $data['montant_paye'];
                
                // Mettre à jour le statut automatiquement
                if ($data['montant_paye'] == 0) {
                    $data['statut'] = 'en_attente';
                } elseif ($data['montant_paye'] == $data['montant_total']) {
                    $data['statut'] = 'payé';
                    $data['date_paiement'] = $data['date_paiement'] ?? now();
                } else {
                    $data['statut'] = 'partiel';
                }
            } else {
                $data['montant_paye'] = 0;
                $data['montant_restant'] = $data['montant_total'];
            }

            // Si c'est un paiement partiel ou complet, enregistrer la date de paiement
            if (in_array($data['statut'], ['payé', 'partiel']) && !isset($data['date_paiement'])) {
                $data['date_paiement'] = now();
            }

            // Si le paiement est payé, mettre à jour la date de validation
            if ($data['statut'] == 'payé') {
                $data['date_validation'] = now();
            }

            // Gérer l'encaissement
            if (in_array($data['statut'], ['payé', 'partiel'])) {
                $data['encaisser_par'] = $data['encaisser_par'] ?? auth()->id();
            }

            // Générer le libellé de période
            if ($request->filled('type_periode') && $request->filled('numero_periode')) {
                $data['periode_libelle'] = $this->genererLibellePeriode(
                    $request->type_periode, 
                    $request->numero_periode
                );
            }

            $paiement = Paiement::create($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement créé avec succès',
                'data' => $paiement->load(['eleve', 'user', 'encaisseur'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mettre à jour un paiement.
     */
    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        // Vérifier si le paiement peut être modifié
        if (!$paiement->peutEtreModifie()) {
            return response()->json([
                'success' => false,
                'message' => 'Ce paiement ne peut plus être modifié'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'montant' => 'nullable|numeric|min:0',
            'montant_total' => 'nullable|numeric|min:0',
            'montant_paye' => 'nullable|numeric|min:0',
            'type_paiement' => 'nullable|in:Scolarité,Cantine,Transport,Fournitures,Activités,Assurance,Autre',
            'type_periode' => 'nullable|in:Trimestre,Semestre,Mois,Annuel',
            'numero_periode' => 'nullable|integer|min:1',
            'annee_scolaire' => 'nullable|string|max:20',
            'date_echeance' => 'nullable|date',
            'date_paiement' => 'nullable|date',
            'mode_paiement' => 'nullable|in:espèces,chèque,virement,carte_bancaire,mobile_money,autre',
            'statut' => 'nullable|in:brouillon,en_attente,partiel,payé,annulé,remboursé',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'motif_annulation' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            // Si montant_paye est modifié, recalculer montant_restant
            if ($request->has('montant_paye')) {
                $montantTotal = $data['montant_total'] ?? $paiement->montant_total;
                $data['montant_restant'] = $montantTotal - $data['montant_paye'];
                
                // Mettre à jour le statut automatiquement
                if ($data['montant_paye'] == 0) {
                    $data['statut'] = 'en_attente';
                } elseif ($data['montant_paye'] == $montantTotal) {
                    $data['statut'] = 'payé';
                    if (!isset($data['date_paiement'])) {
                        $data['date_paiement'] = now();
                    }
                    $data['date_validation'] = now();
                } else {
                    $data['statut'] = 'partiel';
                }
            }

            // Gérer le changement de statut
            if ($request->has('statut')) {
                switch ($data['statut']) {
                    case 'payé':
                        if (!isset($data['date_paiement'])) {
                            $data['date_paiement'] = now();
                        }
                        $data['date_validation'] = now();
                        $data['montant_paye'] = $data['montant_total'] ?? $paiement->montant_total;
                        $data['montant_restant'] = 0;
                        $data['encaisser_par'] = $data['encaisser_par'] ?? auth()->id();
                        break;
                        
                    case 'annulé':
                    case 'remboursé':
                        $data['date_annulation'] = now();
                        break;
                }
            }

            // Mettre à jour le libellé de période si nécessaire
            if ($request->filled('type_periode') || $request->filled('numero_periode')) {
                $typePeriode = $data['type_periode'] ?? $paiement->type_periode;
                $numeroPeriode = $data['numero_periode'] ?? $paiement->numero_periode;
                
                if ($typePeriode && $numeroPeriode) {
                    $data['periode_libelle'] = $this->genererLibellePeriode($typePeriode, $numeroPeriode);
                }
            }

            $paiement->update($data);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement mis à jour avec succès',
                'data' => $paiement->load(['eleve', 'user', 'encaisseur'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprimer un paiement.
     */
    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);

        // Vérifier si le paiement peut être supprimé
        if (!$paiement->peutEtreSupprime()) {
            return response()->json([
                'success' => false,
                'message' => 'Ce paiement ne peut pas être supprimé'
            ], 403);
        }

        try {
            $paiement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Paiement supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enregistrer un paiement partiel.
     */
    public function payerPartiel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'montant_paye' => 'required|numeric|min:0.01',
            'mode_paiement' => 'required|in:espèces,chèque,virement,carte_bancaire,mobile_money,autre',
            'date_paiement' => 'nullable|date',
            'banque' => 'nullable|string|max:100',
            'numero_cheque' => 'nullable|string|max:50',
            'reference_virement' => 'nullable|string|max:100',
            'operateur_mobile' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $paiement = Paiement::findOrFail($id);

        if ($paiement->statut == 'payé') {
            return response()->json([
                'success' => false,
                'message' => 'Ce paiement est déjà entièrement payé'
            ], 400);
        }

        try {
            DB::beginTransaction();

            $montantPaye = $request->montant_paye;
            $nouveauMontantPaye = $paiement->montant_paye + $montantPaye;

            // Vérifier que le montant payé ne dépasse pas le total
            if ($nouveauMontantPaye > $paiement->montant_total) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le montant payé dépasse le montant total dû'
                ], 400);
            }

            // Mettre à jour les informations de paiement
            $paiement->update([
                'montant_paye' => $nouveauMontantPaye,
                'montant_restant' => $paiement->montant_total - $nouveauMontantPaye,
                'mode_paiement' => $request->mode_paiement,
                'date_paiement' => $request->date_paiement ?? now(),
                'encaisser_par' => auth()->id(),
                'banque' => $request->banque,
                'numero_cheque' => $request->numero_cheque,
                'reference_virement' => $request->reference_virement,
                'operateur_mobile' => $request->operateur_mobile,
                'notes' => $request->notes ? ($paiement->notes ? $paiement->notes . "\n" : '') . $request->notes : $paiement->notes,
            ]);

            // Mettre à jour le statut
            if ($nouveauMontantPaye == $paiement->montant_total) {
                $paiement->marquerCommePaye();
            } else {
                $paiement->marquerCommePartiel($nouveauMontantPaye);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement partiel enregistré avec succès',
                'data' => $paiement->load(['eleve', 'user', 'encaisseur'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'enregistrement du paiement partiel',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Marquer un paiement comme entièrement payé.
     */
    public function marquerCommePaye(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mode_paiement' => 'required|in:espèces,chèque,virement,carte_bancaire,mobile_money,autre',
            'date_paiement' => 'nullable|date',
            'banque' => 'nullable|string|max:100',
            'numero_cheque' => 'nullable|string|max:50',
            'reference_virement' => 'nullable|string|max:100',
            'operateur_mobile' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $paiement = Paiement::findOrFail($id);

        if ($paiement->statut == 'payé') {
            return response()->json([
                'success' => false,
                'message' => 'Ce paiement est déjà marqué comme payé'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Mettre à jour les informations de paiement
            $paiement->update([
                'montant_paye' => $paiement->montant_total,
                'montant_restant' => 0,
                'mode_paiement' => $request->mode_paiement,
                'date_paiement' => $request->date_paiement ?? now(),
                'encaisser_par' => auth()->id(),
                'banque' => $request->banque,
                'numero_cheque' => $request->numero_cheque,
                'reference_virement' => $request->reference_virement,
                'operateur_mobile' => $request->operateur_mobile,
                'notes' => $request->notes ? ($paiement->notes ? $paiement->notes . "\n" : '') . $request->notes : $paiement->notes,
            ]);

            // Marquer comme payé
            $paiement->marquerCommePaye();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Paiement marqué comme payé avec succès',
                'data' => $paiement->load(['eleve', 'user', 'encaisseur'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du marquage du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Annuler un paiement.
     */
    public function annuler(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'motif_annulation' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $paiement = Paiement::findOrFail($id);

        try {
            $paiement->annuler($request->motif_annulation);

            return response()->json([
                'success' => true,
                'message' => 'Paiement annulé avec succès',
                'data' => $paiement->load(['eleve', 'user', 'encaisseur'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'annulation du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rembourser un paiement.
     */
    public function rembourser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'motif_annulation' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $paiement = Paiement::findOrFail($id);

        try {
            $paiement->rembourser($request->motif_annulation);

            return response()->json([
                'success' => true,
                'message' => 'Paiement remboursé avec succès',
                'data' => $paiement->load(['eleve', 'user', 'encaisseur'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du remboursement du paiement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Télécharger une preuve de paiement.
     */
    public function uploadPreuve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'preuve_paiement' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $paiement = Paiement::findOrFail($id);

        try {
            // Supprimer l'ancienne preuve si elle existe
            if ($paiement->preuve_paiement) {
                Storage::delete($paiement->preuve_paiement);
            }

            // Enregistrer la nouvelle preuve
            $path = $request->file('preuve_paiement')->store('preuves_paiement');

            $paiement->update([
                'preuve_paiement' => $path
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Preuve de paiement téléchargée avec succès',
                'data' => [
                    'preuve_paiement' => $paiement->preuve_paiement,
                    'preuve_url' => Storage::url($path)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du téléchargement de la preuve',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Générer des rapports de paiements.
     */
    public function rapport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type_paiement' => 'nullable|in:Scolarité,Cantine,Transport,Fournitures,Activités,Assurance,Autre',
            'statut' => 'nullable|in:brouillon,en_attente,partiel,payé,annulé,remboursé',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Paiement::with(['eleve', 'encaisseur'])
                        ->whereBetween('date_paiement', [$request->date_debut, $request->date_fin]);

        if ($request->filled('type_paiement')) {
            $query->where('type_paiement', $request->type_paiement);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }

        $paiements = $query->get();

        // Calculer les totaux
        $totaux = [
            'total_montant' => $paiements->sum('montant_total'),
            'total_paye' => $paiements->sum('montant_paye'),
            'total_restant' => $paiements->sum('montant_restant'),
            'nombre_paiements' => $paiements->count(),
        ];

        // Statistiques par type de paiement
        $statsParType = $paiements->groupBy('type_paiement')->map(function($group) {
            return [
                'nombre' => $group->count(),
                'total_montant' => $group->sum('montant_total'),
                'total_paye' => $group->sum('montant_paye'),
            ];
        });

        // Statistiques par statut
        $statsParStatut = $paiements->groupBy('statut')->map(function($group) {
            return [
                'nombre' => $group->count(),
                'total_montant' => $group->sum('montant_total'),
            ];
        });

        return response()->json([
            'success' => true,
            'periode' => [
                'debut' => $request->date_debut,
                'fin' => $request->date_fin,
            ],
            'filtres' => $request->only(['type_paiement', 'statut', 'eleve_id']),
            'totaux' => $totaux,
            'statistiques' => [
                'par_type' => $statsParType,
                'par_statut' => $statsParStatut,
            ],
            'data' => $paiements
        ]);
    }

    /**
     * Générer le libellé de période.
     */
    private function genererLibellePeriode($typePeriode, $numeroPeriode)
    {
        $libellesMois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        switch ($typePeriode) {
            case 'Mois':
                return isset($libellesMois[$numeroPeriode]) ? $libellesMois[$numeroPeriode] : "Mois {$numeroPeriode}";
            case 'Trimestre':
                return "Trimestre {$numeroPeriode}";
            case 'Semestre':
                return "Semestre {$numeroPeriode}";
            case 'Annuel':
                return "Annuel";
            default:
                return "{$typePeriode} {$numeroPeriode}";
        }
    }

    /**
     * Récupérer les types de paiement disponibles.
     */
    public function typesPaiement()
    {
        $types = [
            'Scolarité' => 'Scolarité',
            'Cantine' => 'Cantine',
            'Transport' => 'Transport',
            'Fournitures' => 'Fournitures',
            'Activités' => 'Activités',
            'Assurance' => 'Assurance',
            'Autre' => 'Autre',
        ];

        return response()->json([
            'success' => true,
            'data' => $types
        ]);
    }

    /**
     * Récupérer les statuts disponibles.
     */
    public function statuts()
    {
        $statuts = [
            'brouillon' => 'Brouillon',
            'en_attente' => 'En attente',
            'partiel' => 'Partiel',
            'payé' => 'Payé',
            'annulé' => 'Annulé',
            'remboursé' => 'Remboursé',
        ];

        return response()->json([
            'success' => true,
            'data' => $statuts
        ]);
    }

    /**
     * Récupérer les modes de paiement disponibles.
     */
    public function modesPaiement()
    {
        $modes = [
            'espèces' => 'Espèces',
            'chèque' => 'Chèque',
            'virement' => 'Virement',
            'carte_bancaire' => 'Carte bancaire',
            'mobile_money' => 'Mobile Money',
            'autre' => 'Autre',
        ];

        return response()->json([
            'success' => true,
            'data' => $modes
        ]);
    }
}