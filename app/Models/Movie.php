<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = ['title', 'description', 'image', 'genre', 'duration'];

    /**
     * Relacionamento com ShowTimes (horários de exibição)
     * Um filme pode ter vários horários de exibição
     */
    public function showTimes()
    {
        return $this->hasMany(ShowTime::class);
    }
}
