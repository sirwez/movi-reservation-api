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
            $totalSeats = $showTime->total_seats;
            $rows = range('A', 'Z'); // Fileiras de A a Z
            $seatsPerRow = 7; // Assentos por fileira

            foreach ($rows as $row) {
                for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                    if (--$totalSeats < 0) break 2; // Para quando atingir o total de assentos

                    Seat::create([
                        'seat' => $row . $seatNumber, // Ex.: A1, A2, ..., Z10
                        'available' => true,
                        'type' => 'Regular',
                        'show_time_id' => $showTime->id,
                    ]);
                }
            }
        }
    }
}
