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
        Schema::create('movie_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('tmdb_id');
            $table->string('title');
            $table->string('poster_path')->nullable();
            $table->json('genre_ids')->nullable();
            $table->date('release_date')->nullable();
            $table->text('overview')->nullable();
            $table->decimal('vote_average', 3, 1)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'tmdb_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_favorites');
    }
};
