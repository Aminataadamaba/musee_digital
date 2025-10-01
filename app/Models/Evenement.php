<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    //
    // use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'image_couverture',
        'lieu',
        'est_actif'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'est_actif' => 'boolean',
    ];

    public function oeuvres()
    {
        return $this->belongsToMany(Oeuvre::class, 'evenement_oeuvres');
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }

    public function scopeEnCours($query)
    {
        return $query->where('date_debut', '<=', now())
                     ->where(function($q) {
                         $q->whereNull('date_fin')
                           ->orWhere('date_fin', '>=', now());
                     });
    }
}
