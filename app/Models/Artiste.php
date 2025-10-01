<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artiste extends Model
{
      use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'biographie',
        'date_naissance',
        'date_deces',
        'nationalite',
        'photo_url',
        'site_web'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_deces' => 'date',
    ];

    // Accesseur: Nom complet
    protected function nomComplet(): Attribute
    {
        return Attribute::make(
            get: fn () => trim("{$this->prenom} {$this->nom}")
        );
    }

    // Relation: Un artiste a plusieurs œuvres
    public function oeuvres()
    {
        return $this->hasMany(Oeuvre::class, 'artiste_id');
    }

    // Scope: Artistes avec œuvres
    public function scopeAvecOeuvres($query)
    {
        return $query->has('oeuvres');
    }
}
