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
        Schema::create('artistes', function (Blueprint $table) {
             $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->text('biographie')->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_deces')->nullable();
            $table->string('nationalite', 100)->nullable();
            $table->string('photo_url', 500)->nullable();
            $table->string('site_web')->nullable();
            $table->timestamps();
            
            $table->index('nom');
            $table->index('nationalite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artistes');
    }
};
