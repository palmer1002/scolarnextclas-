<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = ['titre', 'contenu', 'type', 'cible', 'user_id'];

    public function auteur() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
