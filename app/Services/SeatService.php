<?php

namespace App\Services;

use App\Models\Seat;
use App\Models\ShowTime;

class SeatService
{
    public function adjustSeats($showTimeId, $newTotalSeats)
    {
        $seat = Seat::where('show_time_id', $showTimeId)->delete();
        $this->createSeats($showTimeId, $newTotalSeats);
    }

    public function createSeats($showTimeId, $newTotalSeats)
    {
        $totalSeats = $newTotalSeats;
        $rows = range('A', 'Z');
        $seatsPerRow = 7;

        $seatCount = 0;
        foreach ($rows as $row) {
            for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                if ($seatCount >= $totalSeats) {
                    break 2;
                }
                Seat::create([
                    'seat' => $row . $seatNumber,
                    'available' => true,
                    'type' => 'Regular',
                    'show_time_id' => $showTimeId,
                ]);
                $seatCount++;
            }
        }
    }

    public function moreSeats($showTimeId, $newTotalSeats)
    {
        $showTime = Seat::where('show_time_id', $showTimeId)->orderBy('id', 'desc')->first();
        
        $startingRow = 'A';
        $startingNumber = 1;
        if ($showTime) {
            $lastSeat = $showTime->seat;
            $startingRow = preg_replace('/[0-9]/', '', $lastSeat); 
            $startingNumber = (int)preg_replace('/[A-Z]/', '', $lastSeat);
        }
        
        $totalSeats =  $newTotalSeats;
        $rows = range($startingRow, 'Z');
        $seatsPerRow = 7;
    
        $seatCount = Seat::where('show_time_id', $showTimeId)->count(); 
        foreach ($rows as $row) {
            $seatNumberStart = ($row === $startingRow) ? $startingNumber + 1 : 1; // Ajusta o início do número
            for ($seatNumber = $seatNumberStart; $seatNumber <= $seatsPerRow; $seatNumber++) {
                if ($seatCount >= $totalSeats) {
                    break 2;
                }
                Seat::create([
                    'seat' => $row . $seatNumber,
                    'available' => true,
                    'type' => 'Regular',
                    'show_time_id' => $showTimeId,
                ]);
                $seatCount++;
            }
        }
    }
    
}
