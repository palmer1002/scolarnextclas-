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
        'trimestre',
        'semestre',
        'note',
        'coefficient',
        'annee_scolaire',
    ];

    protected $casts = [
        'note' => 'float',
        'trimestre' => 'integer',
        'semestre' => 'integer',
        'coefficient' => 'integer',
    ];

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