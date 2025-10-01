<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oeuvre extends Model
{
    //  use HasFactory;

    protected $fillable = [
        'titre',
        'artiste_id',
        'categorie_id',
        'description',
        'annee_creation',
        'technique',
        'dimensions',
        'materiau',
        'qr_code',
        'qr_code_image',
        'salle',
        'position_x',
        'position_y',
        'etage',
        'image_principale',
        'audio_description',
        'audio_duree',
        'video_url',
        'video_duree',
        'modele_3d_url',
        'est_visible',
        'est_vedette',
        'ordre_visite',
        'nombre_vues',
        'note_moyenne'
    ];

    protected $casts = [
        'est_visible' => 'boolean',
        'est_vedette' => 'boolean',
        'position_x' => 'decimal:2',
        'position_y' => 'decimal:2',
        'note_moyenne' => 'decimal:2',
    ];

    // Relations
    public function artiste()
    {
        return $this->belongsTo(Artiste::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function traductions()
    {
        return $this->hasMany(OeuvreTraduction::class);
    }

    public function images()
    {
        return $this->hasMany(OeuvreImage::class)->orderBy('ordre');
    }

    public function visites()
    {
        return $this->hasMany(Visite::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function parcours()
    {
        return $this->belongsToMany(Parcours::class, 'parcours_oeuvres')
                    ->withPivot('ordre', 'note_audio', 'texte_complement')
                    ->withTimestamps();
    }

    public function evenements()
    {
        return $this->belongsToMany(Evenement::class, 'evenement_oeuvres')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('est_visible', true);
    }

    public function scopeVedette($query)
    {
        return $query->where('est_vedette', true);
    }

    public function scopeParQrCode($query, $qrCode)
    {
        return $query->where('qr_code', $qrCode);
    }

    public function scopeRecherche($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('titre', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhereHas('artiste', function($q) use ($search) {
                  $q->where('nom', 'LIKE', "%{$search}%")
                    ->orWhere('prenom', 'LIKE', "%{$search}%");
              });
        });
    }

    // Méthodes utilitaires
    public function incrementerVues()
    {
        $this->increment('nombre_vues');
    }

    public function calculerNoteMoyenne()
    {
        $this->note_moyenne = $this->avis()->avg('note') ?? 0;
        $this->save();
    }
}
