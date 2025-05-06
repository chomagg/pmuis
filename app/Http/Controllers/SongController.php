<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Listener;
use App\Models\Playlist;
use App\Models\PlaylistSong;

class SongController extends Controller
{
    public function index(Request $request)
{
    $artists = Artist::all();
    $genres = Genre::all();

    $query = Song::query();

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('artist')) {
        $query->whereHas('album.artist', function ($q) use ($request) {
            $q->where('id', $request->artist);
        });
    }

    if ($request->filled('genre')) {
        $query->where('genre_id', $request->genre);
    }

    $songs = $query->with(['album.artist', 'genre'])->get();

    return view('library.songs', compact('songs', 'artists', 'genres'));
}

    public function indexByGenre(Genre $genre)
    {
 // Estas variables son necesarias para la vista
    $songs = $genre->songs()->latest()->paginate(10);
    $albums = Album::with('artist')->get();
    $genres = Genre::all();
    $artists = Artist::all();

 return view('library.songs', compact('songs', 'genre', 'albums', 'genres', 'artists'));
    }
    
    public function create()
    {
        $artists = Artist::all();    // Todos los artistas
        $albums = Album::with('artist')->get();  // Álbumes con relación a artistas
        $genres = Genre::all();      // Todos los géneros
        
        return view('library.songscreate', compact('artists', 'albums', 'genres'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer',
            'audio_file' => 'required|mimes:mp3,wav,aac|max:10240', // Validación para el archivo de audio
        ]);

        // Subir el archivo de audio
        $audioPath = $request->file('audio_file')->store('audio_files', 'public');

        // Crear la canción
        $song = new Song();
        $song->title = $validated['title'];
        $song->duration = $validated['duration'];
        $song->audio_path = $audioPath;  // Guardar la ruta del archivo
        $song->album_id = $request->album_id;
        $song->genre_id = $request->genre_id;
        $song->artist_id = $request->artist_id;  // Si el artista está presente
        $song->save();

        return redirect()->route('songs.index')->with('success', 'Canción añadida exitosamente');
    }



    public function show(Song $song)
    {
        $song->load(['album.artist', 'genre']);
        return view('songs.show', compact('song'));
    }

    /**
     * Show the form for editing the specified song.
     */
    public function edit(Song $song)
    {
        $albums = Album::with('artist')->get();
        $genres = Genre::all();
        
        return view('songsedit', compact('song', 'albums', 'genres'));
    }

    /**
     * Update the specified song in storage.
     */
    public function update(Request $request, Song $song)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'album_id' => 'nullable|exists:albums,id',
            'genre_id' => 'nullable|exists:genres,id',
            'audio_file' => 'sometimes|file|mimes:mp3,wav,aac|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'duration' => $validated['duration'],
            'album_id' => $validated['album_id'],
            'genre_id' => $validated['genre_id'],
        ];

        if ($request->hasFile('audio_file')) {
            // Eliminar el archivo antiguo
            Storage::disk('public')->delete($song->audio_path);
            
            // Guardar el nuevo archivo
            $data['audio_path'] = $request->file('audio_file')->store('songs', 'public');
        }

        $song->update($data);

        return redirect()->route('songs.index')
            ->with('success', 'Canción actualizada correctamente');
    }

    /**
     * Remove the specified song from storage.
     */
    public function destroy(Song $song)
    {
        Storage::disk('public')->delete($song->audio_path);
        $song->delete();
        
        return back()->with('success', 'Canción eliminada correctamente');
    }

}