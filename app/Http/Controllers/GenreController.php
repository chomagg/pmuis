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

class GenreController extends Controller
{

// En GenreController.php
    public function index()
    {
        $genres = Genre::withCount('songs')->get();
        return view('library.genres', compact('genres')); // Apunta a library/genres.blade.php
    }

    public function create()
    {
       
        return view('library.genrescreate');


    }


    public function store(Request $request)
    {
        // Validación de los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        // Crear el nuevo género
        Genre::create($validated);
    
        // Establecer mensaje flash
        session()->flash('success', 'Género creado exitosamente');
    
        // Redirigir a la lista de géneros o a cualquier otra página
        return redirect()->route('genres.index');
    }
    public function show(string $id)
    {
        //
    }

    public function edit(Genre $genre)
    {
        return view('library.genres.edit', compact('genre')); // Para editar

    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:genres,name,'.$genre->id
        ]);
        
        $genre->update($request->only('name'));
        return redirect()->route('genres.index')->with('success', 'Género actualizado');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return back()->with('success', 'Género eliminado');
    }
}
