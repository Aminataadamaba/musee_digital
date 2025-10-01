<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OeuvreResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'qr_code' => $this->qr_code,
            'description' => $this->description,
            'annee_creation' => $this->annee_creation,
            'technique' => $this->technique,
            'dimensions' => $this->dimensions,
            'salle' => $this->salle,
            'image_principale' => $this->image_principale,
            'est_vedette' => $this->est_vedette,
            'nombre_vues' => $this->nombre_vues,
            'note_moyenne' => $this->note_moyenne,
            'artiste' => [
                'id' => $this->artiste?->id,
                'nom' => $this->artiste?->nom_complet,
                'photo' => $this->artiste?->photo_url,
            ],
            'categorie' => [
                'id' => $this->categorie?->id,
                'nom' => $this->categorie?->nom,
                'couleur' => $this->categorie?->couleur,
                'icone' => $this->categorie?->icone,
            ],
            'url' => $this->url_complete,
            'created_at' => $this->created_at,
        ];
    }
}

