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
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oeuvre_id')->nullable()->constrained('oeuvres')->cascadeOnDelete();
            
            // Informations session
            $table->string('session_id', 100)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip_address', 45)->nullable();
            
            // Données de visite
            $table->string('langue', 5)->nullable();
            $table->integer('duree_consultation')->nullable(); // en secondes
            $table->boolean('a_ecoute_audio')->default(false);
            $table->boolean('a_regarde_video')->default(false);
            $table->boolean('a_partage')->default(false);
            
            // Localisation (optionnelle)
            $table->string('pays', 100)->nullable();
            $table->string('ville', 100)->nullable();
            
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('oeuvre_id');
            $table->index('created_at');
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
