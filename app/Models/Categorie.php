<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
      use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'icone',
        'couleur',
        'ordre'
    ];

    // Relation: Une catégorie a plusieurs œuvres
    public function oeuvres()
    {
        return $this->hasMany(Oeuvre::class, 'categorie_id');
    }

    // Scope: Catégories actives avec œuvres visibles
    public function scopeAvecOeuvresVisibles($query)
    {
        return $query->whereHas('oeuvres', function($q) {
            $q->where('est_visible', true);
        });
    }
}
