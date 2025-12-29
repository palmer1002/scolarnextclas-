<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'trimestre',
        'semestre',
        'moyenne',
        'annee_scolaire',
    ];

    // Relation avec Eleve
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}