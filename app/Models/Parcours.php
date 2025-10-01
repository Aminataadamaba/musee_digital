<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    //
    //    use HasFactory;

    protected $table = 'parcours';

    protected $fillable = [
        'titre',
        'description',
        'duree_estimee',
        'difficulte',
        'image_couverture',
        'couleur',
        'est_actif',
        'ordre',
        'nombre_oeuvres'
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function oeuvres()
    {
        return $this->belongsToMany(Oeuvre::class, 'parcours_oeuvres')
                    ->withPivot('ordre', 'note_audio', 'texte_complement')
                    ->orderByPivot('ordre');
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}
