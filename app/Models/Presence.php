<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'classe_id',
        'date',
        'statut',
        'justifie',
        'motif',
    ];

    protected $casts = [
        'date' => 'date',
        'justifie' => 'boolean',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function scopePresent($query)
    {
        return $query->where('statut', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('statut', 'absent');
    }

    public function scopeRetard($query)
    {
        return $query->where('statut', 'retard');
    }
}
