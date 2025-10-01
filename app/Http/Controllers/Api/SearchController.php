<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
     public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez fournir un terme de recherche'
            ], 400);
        }

        $oeuvres = Oeuvre::with(['artiste', 'categorie'])
            ->visible()
            ->where(function($q) use ($query) {
                $q->where('titre', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('technique', 'LIKE', "%{$query}%")
                  ->orWhereHas('artiste', function($q) use ($query) {
                      $q->where('nom', 'LIKE', "%{$query}%")
                        ->orWhere('prenom', 'LIKE', "%{$query}%");
                  });
            })
            ->limit(20)
            ->get();

        return OeuvreResource::collection($oeuvres);
    }
}
