<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    // Asegúrate de que artist_id esté incluido en los campos rellenables
    protected $fillable = ['title', 'duration', 'album_id', 'genre_id', 'artist_id'];  // Añadido artist_id

    /**
     * Obtener el álbum al que pertenece esta canción.
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Obtener el género al que pertenece esta canción.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);  // Aquí se define la relación inversa
    }

    /**
     * Obtener el artista que creó esta canción.
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);  // Relación con el modelo Artist
    }

    /**
     * Obtener las playlists en las que está esta canción.
     */
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

     /**
     * Obtener la opcion para oyentes 
     */
    public function indexForListeners(Request $request)
    {
        $songs = Song::with(['album.artist', 'genre'])->get();

        $artists = Artist::all();
        $genres = Genre::all();

        return view('songsO', compact('songs', 'artists', 'genres'));
    }
}
