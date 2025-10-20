<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('poster_url', 255)->nullable();
            $table->string('sources_url', 255);
            $table->integer('release_year')->nullable();
            $table->string('type', 10);
            $table->foreignId('genre_id')->nullable()->constrained('genres')->nullOnDelete();
            $table->integer('duration_sec')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->boolean('is_published')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};


