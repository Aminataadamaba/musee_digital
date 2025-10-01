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
        Schema::create('oeuvre_traductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oeuvre_id')->constrained('oeuvres')->cascadeOnDelete();
            $table->string('locale', 5); // fr, en, es, ar, etc.
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->string('technique')->nullable();
            $table->string('audio_description', 500)->nullable();
            $table->timestamps();
            
            $table->unique(['oeuvre_id', 'locale']);
            $table->index('locale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvre_traductions');
    }
};
