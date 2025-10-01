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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oeuvre_id')->constrained('oeuvres')->cascadeOnDelete();
            $table->string('session_id', 100)->nullable();
            $table->tinyInteger('note')->unsigned()->nullable();
            $table->text('commentaire')->nullable();
            $table->boolean('est_modere')->default(false);
            $table->boolean('est_visible')->default(true);
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('oeuvre_id');
            $table->index('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
