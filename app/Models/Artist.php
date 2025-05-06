<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'bio', 'image'];  // Campos que se pueden llenar

    // Relación con las canciones
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    // Relación con los álbumes
    public function albums()
    {
        return $this->hasMany(Album::class); // Un artista tiene muchos álbumes
    }
}
