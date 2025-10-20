<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_casts', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->foreignId('actor_id')->constrained('actors')->cascadeOnDelete();
            $table->string('role_name', 150)->nullable();
            $table->primary(['movie_id', 'actor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_casts');
    }
};


