<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('oeuvres', function (Blueprint $table) {
            $table->id();
           $table->string('titre');
            $table->foreignId('artiste_id')->nullable()->constrained('artistes')->nullOnDelete();
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            
            // Informations de base
            $table->text('description')->nullable();
            $table->string('annee_creation', 50)->nullable();
            $table->string('technique')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('materiau')->nullable();
            
            // QR Code unique
            $table->string('qr_code', 100)->unique();
            $table->string('qr_code_image', 500)->nullable();
            
            // Localisation dans le musée
            $table->string('salle', 100)->nullable();
            $table->decimal('position_x', 10, 2)->nullable();
            $table->decimal('position_y', 10, 2)->nullable();
            $table->integer('etage')->default(0);
            
            // Médias
            $table->string('image_principale', 500)->nullable();
            $table->string('audio_description', 500)->nullable();
            $table->integer('audio_duree')->nullable();
            $table->string('video_url', 500)->nullable();
            $table->integer('video_duree')->nullable();
            $table->string('modele_3d_url', 500)->nullable();
            
            // Visibilité et ordre
            $table->boolean('est_visible')->default(true);
            $table->boolean('est_vedette')->default(false);
            $table->integer('ordre_visite')->default(0);
            
            // Statistiques
            $table->integer('nombre_vues')->default(0);
            $table->decimal('note_moyenne', 3, 2)->default(0);
            
            $table->timestamps();
            
            // Index normaux (sans fulltext)
            $table->index('qr_code');
            $table->index('categorie_id');
            $table->index('est_visible');
            $table->index('est_vedette');
            $table->index('titre'); // Index simple sur titre
            
            // ❌ SUPPRIMÉ: $table->fullText(['titre', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvres');
    }
};
