<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Seat;
use App\Models\ShowTime;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(Request $request)
    {

        $request->validate([
            'show_time_id' => 'required|exists:show_times,id',
            'seats' => 'required|min:1',
            'seats.*.seat_id' => 'required|exists:seats,id',
        ]);

        $showTime = ShowTime::find($request->show_time_id);
        $seats = $request->seats;
        foreach ($seats as $seat) {
            $seat = Seat::find($seat['seat_id']);
            if ($seat->available == false) {
                return response()->json(['error' => 'Seat is not available.'], 400);
            }
        }

        foreach ($seats as $seat) {
            $seat = Seat::find($seat['seat_id']);
            $reservation = $seat->reservation()->create([
                'user_id' => 1,
                'seat_id' => $seat->id,
                'status' => 'confirmed',
                'price' => $showTime->price,
            ]);
            if ($reservation) {
                $seat->available = false;
                $seat->save();
            }
        }
        $reservation = Reservation::with('seat', 'seat.showTime')->whereHas('seat', function ($query) use ($showTime) {
            $query->where('show_time_id', $showTime->id);
        })->where('status', 'confirmed')
            ->where('user_id', 1)
            ->get();

        return response()->json($reservation, 201);
    }
}
