<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listener extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'birthdate'];

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function favoriteSongs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song');
    }
}
