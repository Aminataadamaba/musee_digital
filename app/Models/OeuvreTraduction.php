<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OeuvreTraduction extends Model
{
    //
    //   use HasFactory;

    protected $table = 'oeuvre_traductions';

    protected $fillable = [
        'oeuvre_id',
        'locale',
        'titre',
        'description',
        'technique',
        'audio_description'
    ];

    public function oeuvre()
    {
        return $this->belongsTo(Oeuvre::class);
    }
}
