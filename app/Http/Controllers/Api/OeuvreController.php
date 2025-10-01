<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OeuvreController extends Controller
{
    //
      /**
     * Liste toutes les œuvres visibles
     */
    public function index(Request $request)
    {
        $query = Oeuvre::with(['artiste', 'categorie'])
            ->visible()
            ->orderBy('ordre_visite');

        // Filtres optionnels
        if ($request->has('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->has('salle')) {
            $query->where('salle', $request->salle);
        }

        $oeuvres = $query->paginate($request->get('per_page', 20));

        return OeuvreResource::collection($oeuvres);
    }

    /**
     * Œuvres à la une
     */
    public function vedettes()
    {
        $oeuvres = Oeuvre::with(['artiste', 'categorie'])
            ->visible()
            ->vedette()
            ->orderBy('ordre_visite')
            ->limit(10)
            ->get();

        return OeuvreResource::collection($oeuvres);
    }

    /**
     * Récupérer une œuvre par son QR code
     */
    public function showByQr($qrCode)
    {
        $oeuvre = Oeuvre::with(['artiste', 'categorie', 'traductions'])
            ->where('qr_code', $qrCode)
            ->firstOrFail();

        // Incrémenter le compteur de vues
        $oeuvre->incrementVues();

        return new OeuvreDetailResource($oeuvre);
    }

    /**
     * Œuvres similaires
     */
    public function related(Oeuvre $oeuvre)
    {
        $related = Oeuvre::with(['artiste', 'categorie'])
            ->visible()
            ->where('id', '!=', $oeuvre->id)
            ->where(function($query) use ($oeuvre) {
                $query->where('categorie_id', $oeuvre->categorie_id)
                      ->orWhere('artiste_id', $oeuvre->artiste_id);
            })
            ->limit(6)
            ->get();

        return OeuvreResource::collection($related);
    }
}
