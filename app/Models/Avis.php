<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    //
     use HasFactory;

    public $timestamps = false;

    protected $table = 'avis';

    protected $fillable = [
        'oeuvre_id',
        'session_id',
        'note',
        'commentaire',
        'est_modere',
        'est_visible'
    ];

    protected $casts = [
        'est_modere' => 'boolean',
        'est_visible' => 'boolean',
    ];

    public function oeuvre()
    {
        return $this->belongsTo(Oeuvre::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('est_visible', true)->where('est_modere', true);
    }
}
