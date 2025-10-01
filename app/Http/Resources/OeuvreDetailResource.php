<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OeuvreDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $locale = $request->get('locale', 'fr');
        $traduction = $this->traduction($locale);

        return [
            'id' => $this->id,
            'titre' => $traduction?->titre ?? $this->titre,
            'description' => $traduction?->description ?? $this->description,
            'qr_code' => $this->qr_code,
            'annee_creation' => $this->annee_creation,
            'technique' => $traduction?->technique ?? $this->technique,
            'dimensions' => $this->dimensions,
            'materiau' => $this->materiau,
            'salle' => $this->salle,
            'etage' => $this->etage,
            'position' => [
                'x' => $this->position_x,
                'y' => $this->position_y,
            ],
            'medias' => [
                'image_principale' => $this->image_principale,
                'audio' => [
                    'url' => $traduction?->audio_description ?? $this->audio_description,
                    'duree' => $this->audio_duree,
                ],
                'video' => [
                    'url' => $this->video_url,
                    'duree' => $this->video_duree,
                ],
                'modele_3d' => $this->modele_3d_url,
            ],
            'artiste' => [
                'id' => $this->artiste?->id,
                'nom_complet' => $this->artiste?->nom_complet,
                'biographie' => $this->artiste?->biographie,
                'nationalite' => $this->artiste?->nationalite,
                'photo' => $this->artiste?->photo_url,
            ],
            'categorie' => [
                'id' => $this->categorie?->id,
                'nom' => $this->categorie?->nom,
                'couleur' => $this->categorie?->couleur,
                'icone' => $this->categorie?->icone,
            ],
            'statistiques' => [
                'nombre_vues' => $this->nombre_vues,
                'note_moyenne' => $this->note_moyenne,
            ],
            'langues_disponibles' => $this->traductions->pluck('locale'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
