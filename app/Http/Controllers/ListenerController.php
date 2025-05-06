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

class ListenerController extends Controller
{
    public function index()
    {
        return view('library.listeners'); // Renderiza resources/views/library/listeners.blade.php
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function dashboard()
    {
        $songs = Song::with(['artist', 'album', 'genre'])->get(); // Traer relaciones si las tienes

        return view('library.listeners', compact('songs'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
