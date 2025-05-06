<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'listener_id'];

    public function listener()
    {
        return $this->belongsTo(Listener::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song');
    }
}
