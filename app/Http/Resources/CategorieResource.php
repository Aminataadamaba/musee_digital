<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array

    {
         return [
            'id' => $this->id,
            'nom' => $this->nom,
            'slug' => $this->slug,
            'description' => $this->description,
            'icone' => $this->icone,
            'couleur' => $this->couleur,
            'nombre_oeuvres' => $this->oeuvres_count ?? $this->oeuvres->count(),
        ];
        // return parent::toArray($request);
    }
}
