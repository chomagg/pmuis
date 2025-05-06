<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListenerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//rutas del proyecto
Route::resource('artists', ArtistController::class);
Route::resource('albums', AlbumController::class);
Route::resource('songs', SongController::class);
Route::resource('genres', GenreController::class);
// Canciones dentro de un género
Route::resource('genres.songs', SongController::class);

// Rutas para el Panel de Artista
Route::middleware(['auth', 'role:artist'])->group(function() {
    Route::get('/artist/dashboard', [DashboardController::class, 'artistDashboard'])->name('artist.dashboard');
    Route::get('/artist/add-music', [ArtistController::class, 'addMusic'])->name('artist.add_music'); // Agregar música
});

// Rutas para el Panel de Oyente
Route::middleware(['auth', 'role:listener'])->group(function() {
    Route::get('/listener/dashboard', [ListenerController::class, 'dashboard'])->name('listener.dashboard'); // MOSTRAR canciones
    Route::get('/listener/create-playlist', [ListenerController::class, 'createPlaylist'])->name('listener.create_playlist'); // Crear playlist
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
