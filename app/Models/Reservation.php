<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'seat_id', 'status', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    // Acessar o show_time pelo relacionamento do seat
    public function showTime()
    {
        return $this->seat->showTime(); // Usa o relacionamento definido em Seat
    }
}
