<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use App\Models\Genre;
use App\Models\Listener;
use App\Models\Playlist;
use App\Models\PlaylistSong;

class AlbumController extends Controller
{
    public function index()
    {
        // Obtener todos los álbumes con su respectivo artista y canciones
        $albums = Album::with('artist', 'songs')->get();

        // Asegurarse de que la fecha de lanzamiento sea una instancia de Carbon
        foreach ($albums as $album) {
            if ($album->release_date && !$album->release_date instanceof \Carbon\Carbon) {
                $album->release_date = \Carbon\Carbon::parse($album->release_date);
            }
        }

        // Obtener los artistas para el formulario de creación (si es necesario)
        $artists = Artist::all();

        // Retornar la vista con los álbumes y artistas disponibles
        return view('library.albums', compact('albums', 'artists'));
    }

    public function create()
    {
        // Obtener los artistas para el formulario
        $artists = Artist::all();
        return view('library.albums.create', compact('artists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'nullable|date',
            'artist_id' => 'required|exists:artists,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Procesar la imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('albums', 'public');
            
            // Opcional: Generar nombre único para el archivo
            // $imageName = time().'.'.$request->image->extension();  
            // $imagePath = $request->image->storeAs('albums', $imageName, 'public');
        }

        // Crear el álbum
        $album = Album::create([
            'title' => $validated['title'],
            'release_date' => $validated['release_date'],
            'artist_id' => $validated['artist_id'],
            'image' => $imagePath,
        ]);

        // Redireccionar con mensaje
        return redirect()->route('albums.index')
            ->with('success', 'Álbum creado correctamente');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
