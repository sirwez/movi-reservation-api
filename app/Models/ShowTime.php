<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowTime extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = ['show_time', 'room', 'date', 'price', 'total_seats', 'movie_id'];

    /**
     * Relacionamento com Movie
     * Um horário de exibição pertence a um filme
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Relacionamento com Seats
     * Um horário de exibição pode ter vários assentos
     */
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
