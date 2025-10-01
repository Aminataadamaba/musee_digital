<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    //
     public function index()
    {
        $categories = Categorie::withCount('oeuvres')
            ->orderBy('ordre')
            ->get();

        return CategorieResource::collection($categories);
    }

    public function show(Categorie $categorie)
    {
        $categorie->load('oeuvres');
        return new CategorieResource($categorie);
    }

    public function oeuvres(Categorie $categorie)
    {
        $oeuvres = $categorie->oeuvres()
            ->with(['artiste'])
            ->visible()
            ->orderBy('ordre_visite')
            ->paginate(20);

        return OeuvreResource::collection($oeuvres);
    }
}
