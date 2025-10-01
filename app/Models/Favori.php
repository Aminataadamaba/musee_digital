<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    //
     use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'oeuvre_id'
    ];

    public function oeuvre()
    {
        return $this->belongsTo(Oeuvre::class);
    }
}
