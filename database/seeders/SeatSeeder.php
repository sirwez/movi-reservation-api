<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;
use App\Models\ShowTime;

class SeatSeeder extends Seeder
{
    public function run()
    {
        $showTimes = ShowTime::all(); // Recupera os horários de exibição

        foreach ($showTimes as $showTime) {
            for ($row = 'A'; $row <= 'C'; $row++) { // Fileiras A, B, C
                for ($seatNumber = 1; $seatNumber <= 10; $seatNumber++) { // Assentos 1 a 10
                    Seat::create([
                        'seat' => $row . $seatNumber, // Ex.: A1, A2, ..., C10
                        'available' => true,
                        'type' => 'Regular',
                        'show_time_id' => $showTime->id,
                    ]);
                }
            }
        }
    }
}
