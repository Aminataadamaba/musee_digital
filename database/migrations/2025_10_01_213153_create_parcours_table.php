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
        Schema::create('parcours', function (Blueprint $table) {
            $table->id();
             $table->string('titre');
            $table->text('description')->nullable();
            $table->integer('duree_estimee')->nullable(); // en minutes
            $table->enum('difficulte', ['facile', 'moyen', 'difficile'])->default('facile');
            $table->string('image_couverture', 500)->nullable();
            $table->string('couleur', 7)->default('#000000');
            $table->boolean('est_actif')->default(true);
            $table->integer('ordre')->default(0);
            $table->integer('nombre_oeuvres')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcours');
    }
};
