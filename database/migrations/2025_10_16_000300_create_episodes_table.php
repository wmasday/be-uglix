<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->cascadeOnDelete();
            $table->integer('season_number');
            $table->integer('episode_number');
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('duration_sec')->nullable();
            $table->string('sources_url', 255);
            $table->string('thumbnail_url', 255)->nullable();
            $table->date('release_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};


