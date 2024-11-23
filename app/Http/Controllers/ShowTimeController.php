<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\ShowTime;
use App\Services\SeatService;
use Illuminate\Http\Request;

class ShowTimeController extends Controller
{
    public function index()
    {
        $showTimes = ShowTime::with('movie')->get();
        return response()->json($showTimes, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'show_time' => 'required',
            'room' => 'required',
            'date' => 'required',
            'price' => 'required|numeric',
            'total_seats' => 'required|numeric',
            'movie_id' => 'required| exists:movies,id',
        ]);

        $showTime = ShowTime::create([
            'show_time' => $request->show_time,
            'room' => $request->room,
            'date' => $request->date,
            'price' => $request->price,
            'total_seats' => $request->total_seats,
            'movie_id' => $request->movie_id,
        ]);

        return response()->json($showTime, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'show_time' => 'required',
            'room' => 'required',
            'date' => 'required',
            'price' => 'required|numeric',
            'total_seats' => 'required|numeric',
            'movie_id' => 'required| exists:movies,id',
        ]);

        $showTime = ShowTime::find($id);
        if ($showTime == null) {
            return response()->json(['message' => 'ShowTime not found'], 404);
        }

        $showTime->show_time = $request->show_time;
        $showTime->room = $request->room;
        $showTime->date = $request->date;
        $showTime->price = $request->price;
        if ( $request->total_seats > $showTime->total_seats) {
            $showTime->total_seats = $request->total_seats;
            (new SeatService())->moreSeats($showTime->id, $request->total_seats);
        } else if ($request->total_seats < $showTime->total_seats) {
            $reservation = Seat::where('show_time_id', $showTime->id)->with('reservation')->where('available', true)->whereHas('reservation')->count();
            if ($reservation) {
                return response()->json(['error' => 'Seats cannot be readjusted as there are already reservations.'], 400);
            } else {
                (new SeatService())->adjustSeats($showTime->id, $request->total_seats);
            }
        }
        $showTime->total_seats = $request->total_seats;
        $showTime->movie_id = $request->movie_id;
        $showTime->save();

        return response()->json($showTime, 200);
    }
}
