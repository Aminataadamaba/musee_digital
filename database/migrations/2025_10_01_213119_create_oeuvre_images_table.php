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
        Schema::create('oeuvre_images', function (Blueprint $table) {
            $table->id();
             $table->foreignId('oeuvre_id')->constrained('oeuvres')->cascadeOnDelete();
            $table->string('url', 500);
            $table->text('legende')->nullable();
            $table->integer('ordre')->default(0);
            $table->timestamp('created_at')->useCurrent();
            
            $table->index('oeuvre_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oeuvre_images');
    }
};
