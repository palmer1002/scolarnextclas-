<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistiqueCache extends Model
{
    use HasFactory;

    protected $table = 'statistiques_cache';
    
    protected $fillable = ['type', 'valeur'];
    
    public $timestamps = false;
    const UPDATED_AT = 'updated_at';
}