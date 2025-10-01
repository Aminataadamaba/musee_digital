<?php

// ==========================================
// routes/api.php
// ==========================================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OeuvreController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\ArtisteController;
use App\Http\Controllers\Api\VisiteController;
use App\Http\Controllers\Api\SearchController;

// Œuvres
Route::get('/oeuvres', [OeuvreController::class, 'index']);
Route::get('/oeuvres/vedettes', [OeuvreController::class, 'vedettes']);
Route::get('/oeuvres/{qrCode}', [OeuvreController::class, 'showByQr']);
Route::get('/oeuvres/{oeuvre}/related', [OeuvreController::class, 'related']);

// Catégories
Route::get('/categories', [CategorieController::class, 'index']);
Route::get('/categories/{categorie}', [CategorieController::class, 'show']);
Route::get('/categories/{categorie}/oeuvres', [CategorieController::class, 'oeuvres']);

// Artistes
Route::get('/artistes', [ArtisteController::class, 'index']);
Route::get('/artistes/{artiste}', [ArtisteController::class, 'show']);

// Visites & Analytics
Route::post('/visites', [VisiteController::class, 'store']);
Route::get('/stats/populaires', [VisiteController::class, 'populaires']);

// Recherche
Route::get('/search', [SearchController::class, 'search']);
