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
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('release_date')->nullable();
            $table->unsignedBigInteger('artist_id');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Actualizamos la tabla songs
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('duration'); // en segundos
            $table->unsignedBigInteger('album_id')->nullable();
            $table->unsignedBigInteger('genre_id')->nullable();
            $table->unsignedBigInteger('artist_id'); // Nueva columna para la relación con el artista
            $table->string('audio_path'); // Aquí no debe ser nulo
            $table->integer('play_count')->default(0); // Contador de reproducciones
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('set null');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
            $table->foreign('artist_id')->references('id')->on('artists')->onDelete('cascade'); // Relación con artistas
            $table->timestamps();
        });

        Schema::create('listeners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Añadido para autenticación
            $table->date('birthdate')->nullable();
            $table->rememberToken(); // Para "recordar sesión"
            $table->timestamps();
        });

        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('listener_id');
            $table->string('cover_image')->nullable();
            $table->foreign('listener_id')->references('id')->on('listeners')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('playlist_songs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedBigInteger('song_id');
            $table->integer('position')->default(0); // Orden en la playlist
            $table->foreign('playlist_id')->references('id')->on('playlists')->onDelete('cascade');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabla para favoritos
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listener_id');
            $table->unsignedBigInteger('song_id');
            $table->foreign('listener_id')->references('id')->on('listeners')->onDelete('cascade');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('playlist_songs');
        Schema::dropIfExists('playlists');
        Schema::dropIfExists('listeners');
        Schema::dropIfExists('songs');
        Schema::dropIfExists('albums');
        Schema::dropIfExists('genres');
        Schema::dropIfExists('artists');
    }
};
