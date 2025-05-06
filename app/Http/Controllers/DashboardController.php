<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;  // <-- 💥
use App\Models\Artist;



class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role == 'listener') {
            return view('library.listeners');
        }
    
        return view('dashboard');
    }

    /**
     * Muestra el dashboard para los arStistas.
     */
    public function artistDashboard()
    {
        // Obtener todos los artistas
        $artists = Artist::all();  // O alguna consulta específica según lo que necesites

        // Pasar la variable 'artists' a la vista
        return view('library.artists', compact('artists'));
    }


    /**
     * Muestra el dashboard para los oyentes.
     */
    public function listenerDashboard()
    {
        // Aquí puedes retornar la vista del panel de oyente.
        return view('library.listeners'); // Cambia esto por la vista correcta para los oyentes
    }
}
