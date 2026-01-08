<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'niveau',
        'section',
        'capacite_max',
        'annee_scolaire',
        'statut',
        'description',
    ];

    protected $casts = [
        'statut' => 'boolean',
        'capacite_max' => 'integer',
        'annee_scolaire' => 'integer',
    ];

    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
    }

    public function getNomCompletAttribute(): string
    {
        // Afficher uniquement le niveau
        return (string) $this->niveau;
    }
}