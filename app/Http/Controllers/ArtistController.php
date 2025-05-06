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


class ArtistController extends Controller
{

    /**
     * Display a listing of the resource.
     */
        // Mostrar todos los artistas
    public function index()
    {
        $artists = Artist::all();  // Obtener todos los artistas
        return view('library.artists', compact('artists'));  // Pasar los artistas a la vista
        
    }

    public function dashboard()
    {
        return view('artist.dashboard');
    }
        

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('library.artists.create');
    }


    // Insertar un nuevo artista
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        // Subir la imagen si se ha proporcionado
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('artists', 'public');
        }

        // Crear el artista en la base de datos
        Artist::create([
            'name' => $validated['name'],
            'bio' => $validated['bio'],
            'image' => $imagePath, // Guardar la ruta relativa de la imagen
        ]);

        return redirect()->route('artists.index');  // Redirigir a la lista de artistas
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
