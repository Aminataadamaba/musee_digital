<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OeuvreImage extends Model
{
    //
    //  use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'oeuvre_id',
        'url',
        'legende',
        'ordre'
    ];

    public function oeuvre()
    {
        return $this->belongsTo(Oeuvre::class);
    }
}
