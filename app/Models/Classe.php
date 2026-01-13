<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\Bulletin;
use App\Models\User;
use App\Models\Matiere;
use App\Models\Enseignants;




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