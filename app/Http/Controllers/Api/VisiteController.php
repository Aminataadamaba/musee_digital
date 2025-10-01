<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisiteController extends Controller
{
    //
     public function store(Request $request)
    {
        $validated = $request->validate([
            'oeuvre_id' => 'required|exists:oeuvres,id',
            'session_id' => 'nullable|string|max:100',
            'duree_consultation' => 'nullable|integer',
            'a_ecoute_audio' => 'boolean',
            'a_regarde_video' => 'boolean',
            'a_partage' => 'boolean',
            'langue' => 'nullable|string|max:5',
        ]);

        $visite = Visite::create([
            ...$validated,
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Visite enregistrée',
            'data' => $visite
        ], 201);
    }

    /**
     * Œuvres les plus populaires
     */
    public function populaires()
    {
        $oeuvres = Oeuvre::with(['artiste', 'categorie'])
            ->visible()
            ->orderBy('nombre_vues', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $oeuvres
        ]);
    }
}
