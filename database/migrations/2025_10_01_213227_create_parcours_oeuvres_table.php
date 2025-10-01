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
        Schema::create('parcours_oeuvres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcours_id')->constrained('parcours')->cascadeOnDelete();
            $table->foreignId('oeuvre_id')->constrained('oeuvres')->cascadeOnDelete();
            $table->integer('ordre')->default(0);
            $table->string('note_audio', 500)->nullable();
            $table->text('texte_complement')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->unique(['parcours_id', 'oeuvre_id']);
            $table->index('ordre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcours_oeuvres');
    }
};
