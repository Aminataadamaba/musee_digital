<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    //
    //  use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'oeuvre_id',
        'session_id',
        'user_agent',
        'ip_address',
        'langue',
        'duree_consultation',
        'a_ecoute_audio',
        'a_regarde_video',
        'a_partage',
        'pays',
        'ville'
    ];

    protected $casts = [
        'a_ecoute_audio' => 'boolean',
        'a_regarde_video' => 'boolean',
        'a_partage' => 'boolean',
    ];

    public function oeuvre()
    {
        return $this->belongsTo(Oeuvre::class);
    }
}
