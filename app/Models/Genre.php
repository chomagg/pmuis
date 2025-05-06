<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // ¡Import clave!



class Genre extends Model
{
    use HasFactory;  // Asegúrate de que 'use' esté aquí correctamente.

    // Permitir la asignación masiva de campos
    protected $fillable = ['name'];

    /**
     * Obtener las canciones asociadas con este género.
     */
    public function songs()
    {
        return $this->hasMany(Song::class);  // Asegúrate de que "Song::class" sea el nombre correcto de tu modelo de canciones
    }
}


