<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_date', 'artist_id', 'image']; // Añade 'image'

    // Indicar que 'release_date' es un campo de fecha
    protected $dates = ['release_date'];

    // Relación con el modelo Artist
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    // Relación con el modelo Song
    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}

