<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Paiement extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'eleve_id',
        'user_id',
        'encaisser_par',
        'numero_recu',
        'reference',
        'montant',
        'montant_total',
        'montant_restant',
        'montant_paye',
        'date_paiement',
        'date_echeance',
        'prochain_paiement',
        'type_periode',
        'numero_periode',
        'periode_libelle',
        'annee_scolaire',
        'type_paiement',
        'mode_paiement',
        'banque',
        'numero_cheque',
        'reference_virement',
        'operateur_mobile',
        'statut',
        'is_recurrent',
        'frequence_recurrence',
        'preuve_paiement',
        'description',
        'notes',
        'motif_annulation',
        'date_validation',
        'date_annulation'
    ];

    /**
     * Les attributs à caster.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'montant_restant' => 'decimal:2',
        'montant_paye' => 'decimal:2',
        'date_paiement' => 'date',
        'date_echeance' => 'date',
        'prochain_paiement' => 'date',
        'date_validation' => 'datetime',
        'date_annulation' => 'datetime',
        'is_recurrent' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Les valeurs par défaut du modèle.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'statut' => 'brouillon', // Correspond au default de la migration
        'mode_paiement' => 'espèces',
        'type_paiement' => 'Scolarité',
        'montant_total' => 0,
        'montant_restant' => 0,
        'montant_paye' => 0,
        'is_recurrent' => false,
    ];

    /**
     * Les attributs calculés (accesseurs).
     *
     * @var array
     */
    protected $appends = [
        'est_complet',
        'est_en_retard',
        'jours_retard',
        'pourcentage_paye',
        'date_paiement_format',
        'type_paiement_complet'
    ];

    // Supprimer l'accesseur montant_paye car il est déjà un champ dans la table
    // Le getMontantPayeAttribute() sera commenté ci-dessous

    /**
     * Relation avec l'élève.
     */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /**
     * Relation avec l'utilisateur (qui a créé le paiement).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation avec l'utilisateur qui a encaissé.
     */
    public function encaisseur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'encaisser_par');
    }

    /**
     * Accesseur : Vérifie si le paiement est complet.
     */
    public function getEstCompletAttribute(): bool
    {
        return $this->montant_restant == 0 && $this->statut == 'payé';
    }

    /**
     * Accesseur : Vérifie si le paiement est en retard.
     */
    public function getEstEnRetardAttribute(): bool
    {
        if (!$this->date_echeance || in_array($this->statut, ['payé', 'annulé', 'remboursé'])) {
            return false;
        }
        
        return Carbon::now()->greaterThan(Carbon::parse($this->date_echeance));
    }

    /**
     * Accesseur : Nombre de jours de retard.
     */
    public function getJoursRetardAttribute(): ?int
    {
        if (!$this->date_echeance || in_array($this->statut, ['payé', 'annulé', 'remboursé'])) {
            return null;
        }
        
        $jours = Carbon::now()->diffInDays(Carbon::parse($this->date_echeance), false);
        return $jours > 0 ? 0 : abs($jours);
    }

    /**
     * Accesseur : Pourcentage du paiement effectué.
     */
    public function getPourcentagePayeAttribute(): float
    {
        if ($this->montant_total == 0) {
            return 0;
        }
        
        return round(($this->montant_paye / $this->montant_total) * 100, 2);
    }

    /**
     * Accesseur : Date de paiement formatée.
     */
    public function getDatePaiementFormatAttribute(): string
    {
        return $this->date_paiement ? $this->date_paiement->format('d/m/Y') : 'Non payé';
    }

    /**
     * Accesseur : Type de paiement avec détails.
     */
    public function getTypePaiementCompletAttribute(): string
    {
        $type = $this->type_paiement;
        
        if ($this->periode_libelle) {
            $type .= " - {$this->periode_libelle}";
        }
        
        if ($this->annee_scolaire) {
            $type .= " ({$this->annee_scolaire})";
        }
        
        return $type;
    }

    /**
     * Accesseur : Code couleur selon le statut.
     */
    public function getCouleurStatutAttribute(): string
    {
        return match($this->statut) {
            'payé' => 'success',
            'en_attente' => $this->est_en_retard ? 'danger' : 'warning',
            'partiel' => 'info',
            'annulé', 'remboursé' => 'secondary',
            'brouillon' => 'light',
            default => 'light'
        };
    }

    /**
     * Accesseur : Icône selon le statut.
     */
    public function getIconeStatutAttribute(): string
    {
        return match($this->statut) {
            'payé' => 'check-circle',
            'en_attente' => 'clock',
            'partiel' => 'percent',
            'annulé' => 'x-circle',
            'remboursé' => 'arrow-counterclockwise',
            'brouillon' => 'pencil',
            default => 'question-circle'
        };
    }

    /**
     * Scope : Paiements payés.
     */
    public function scopePayes(Builder $query): Builder
    {
        return $query->where('statut', 'payé');
    }

    /**
     * Scope : Paiements en attente.
     */
    public function scopeEnAttente(Builder $query): Builder
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope : Paiements partiels.
     */
    public function scopePartiels(Builder $query): Builder
    {
        return $query->where('statut', 'partiel');
    }

    /**
     * Scope : Paiements annulés.
     */
    public function scopeAnnules(Builder $query): Builder
    {
        return $query->where('statut', 'annulé');
    }

    /**
     * Scope : Paiements remboursés.
     */
    public function scopeRembourses(Builder $query): Builder
    {
        return $query->where('statut', 'remboursé');
    }

    /**
     * Scope : Paiements en retard.
     */
    public function scopeEnRetard(Builder $query): Builder
    {
        return $query->where('statut', 'en_attente')
                     ->where('date_echeance', '<', now());
    }

    /**
     * Scope : Pour un élève spécifique.
     */
    public function scopePourEleve(Builder $query, int $eleveId): Builder
    {
        return $query->where('eleve_id', $eleveId);
    }

    /**
     * Scope : Pour un type de période.
     */
    public function scopePourTypePeriode(Builder $query, string $type): Builder
    {
        return $query->where('type_periode', $type);
    }

    /**
     * Scope : Pour une période spécifique.
     */
    public function scopePourPeriode(Builder $query, string $type, int $numero): Builder
    {
        return $query->where('type_periode', $type)
                     ->where('numero_periode', $numero);
    }

    /**
     * Scope : Pour une année scolaire.
     */
    public function scopePourAnneeScolaire(Builder $query, string $annee): Builder
    {
        return $query->where('annee_scolaire', $annee);
    }

    /**
     * Scope : Paiements par type.
     */
    public function scopeParType(Builder $query, string $type): Builder
    {
        return $query->where('type_paiement', $type);
    }

    /**
     * Scope : Paiements entre deux dates.
     */
    public function scopeEntreDates(Builder $query, ?string $dateDebut, ?string $dateFin): Builder
    {
        if ($dateDebut) {
            $query->where('date_paiement', '>=', $dateDebut);
        }
        
        if ($dateFin) {
            $query->where('date_paiement', '<=', $dateFin);
        }
        
        return $query;
    }

    /**
     * Scope : Paiements récurrents.
     */
    public function scopeRecurrents(Builder $query): Builder
    {
        return $query->where('is_recurrent', true);
    }

    /**
     * Marquer le paiement comme payé.
     */
    public function marquerCommePaye(?string $datePaiement = null): bool
    {
        $this->statut = 'payé';
        $this->montant_restant = 0;
        $this->montant_paye = $this->montant_total;
        $this->date_paiement = $datePaiement ?: now();
        $this->date_validation = now();
        
        return $this->save();
    }

    /**
     * Marquer le paiement comme partiellement payé.
     */
    public function marquerCommePartiel(float $montantPaye): bool
    {
        $this->statut = 'partiel';
        $this->montant_paye = $montantPaye;
        $this->montant_restant = $this->montant_total - $montantPaye;
        
        if ($this->montant_restant <= 0) {
            return $this->marquerCommePaye();
        }
        
        return $this->save();
    }

    /**
     * Annuler le paiement.
     */
    public function annuler(string $raison = null): bool
    {
        $this->statut = 'annulé';
        $this->motif_annulation = $raison;
        $this->date_annulation = now();
        
        return $this->save();
    }

    /**
     * Rembourser le paiement.
     */
    public function rembourser(string $raison = null): bool
    {
        $this->statut = 'remboursé';
        $this->motif_annulation = $raison;
        $this->date_annulation = now();
        
        return $this->save();
    }

    /**
     * Générer un numéro de reçu automatique.
     */
    public static function genererNumeroRecu(): string
    {
        $prefix = 'RECU-' . date('Y') . '-';
        $dernier = self::where('numero_recu', 'like', $prefix . '%')
                      ->orderBy('numero_recu', 'desc')
                      ->first();
        
        if ($dernier && $dernier->numero_recu) {
            $numero = intval(str_replace($prefix, '', $dernier->numero_recu)) + 1;
        } else {
            $numero = 1;
        }
        
        return $prefix . str_pad($numero, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Calculer les statistiques de paiement.
     */
    public static function statistiques(?int $eleveId = null): array
    {
        $query = self::query();
        
        if ($eleveId) {
            $query->where('eleve_id', $eleveId);
        }
        
        return [
            'total_paiements' => $query->count(),
            'total_montant' => $query->sum('montant_total'),
            'total_paye' => $query->sum('montant_paye'),
            'total_restant' => $query->sum('montant_restant'),
            'payes' => $query->where('statut', 'payé')->count(),
            'en_attente' => $query->where('statut', 'en_attente')->count(),
            'partiels' => $query->where('statut', 'partiel')->count(),
            'annules' => $query->where('statut', 'annulé')->count(),
            'rembourses' => $query->where('statut', 'remboursé')->count(),
            'brouillons' => $query->where('statut', 'brouillon')->count(),
            'en_retard' => $query->where('statut', 'en_attente')
                                ->where('date_echeance', '<', now())
                                ->count(),
        ];
    }

    /**
     * Vérifier si un paiement peut être modifié.
     */
    public function peutEtreModifie(): bool
    {
        return !in_array($this->statut, ['payé', 'annulé', 'remboursé']);
    }

    /**
     * Vérifier si un paiement peut être supprimé.
     */
    public function peutEtreSupprime(): bool
    {
        return in_array($this->statut, ['brouillon', 'en_attente']);
    }

    /**
     * Boot du modèle.
     */
    protected static function boot()
    {
        parent::boot();

        // Générer automatiquement le numéro de reçu
        static::creating(function ($paiement) {
            if (empty($paiement->numero_recu)) {
                $paiement->numero_recu = self::genererNumeroRecu();
            }
            
            // S'assurer que montant_total est défini
            if (empty($paiement->montant_total) && isset($paiement->montant)) {
                $paiement->montant_total = $paiement->montant;
            }
            
            // Initialiser les montants
            if (empty($paiement->montant_paye)) {
                $paiement->montant_paye = 0;
            }
            
            if (empty($paiement->montant_restant) && isset($paiement->montant_total)) {
                $paiement->montant_restant = $paiement->montant_total - $paiement->montant_paye;
            }
        });

        // Mettre à jour la date de modification
        static::updating(function ($paiement) {
            if ($paiement->isDirty('statut')) {
                switch ($paiement->statut) {
                    case 'payé':
                        $paiement->date_paiement = $paiement->date_paiement ?: now();
                        $paiement->date_validation = now();
                        $paiement->montant_paye = $paiement->montant_total;
                        $paiement->montant_restant = 0;
                        break;
                        
                    case 'annulé':
                    case 'remboursé':
                        $paiement->date_annulation = now();
                        break;
                }
            }
        });
    }
}