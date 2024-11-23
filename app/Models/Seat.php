<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    // Campos que podem ser preenchidos em massa
    protected $fillable = ['seat', 'available', 'type', 'show_time_id'];

    /**
     * Relacionamento com ShowTime
     * Um assento pertence a um horário de exibição
     */
    public function showTime()
    {
        return $this->belongsTo(ShowTime::class);
    }
}
