<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'type_periode',
        'numero_periode',
        'type_evaluation',
        'num_evaluation',
        'note',
        'coefficient',
        'annee_scolaire',
    ];
    protected $casts = [
        'note' => 'float',
        'numero_periode' => 'integer',
        'coefficient' => 'integer',
    ];

    // Accessor pour compatibilité avec le reste du code si nécessaire
    public function getTrimestreAttribute()
    {
        return $this->type_periode === 'Trimestre' ? $this->numero_periode : null;
    }

    // Relation avec Eleve
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    // Relation avec Matiere
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}