<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Reservation;
use App\Models\ShowTime;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Commands\Show;

class AdminPanelController extends Controller
{
    public function listByMovie(Request $request)
    {
        $receipts = Reservation::with('seat.showTime.movie')->whereHas('seat.showTime.movie', function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->title . '%');
        })->where('status', 'confirmed')->get();
        $amount = 0;
        foreach ($receipts as $receipt) {
            $amount = $amount + $receipt->seat->showTime->price;
        }
        return response()->json(['receipts' => $receipts, 'amount' => $amount	], 200);
    }

    public function list() {
        $receipts = Reservation::with('seat.showTime.movie')->where('status', 'confirmed')->get();
        $amount = 0;
        foreach ($receipts as $receipt) {
            $amount = $amount + $receipt->seat->showTime->price;
        }
        return response()->json(['receipts' => $receipts, 'amount' => $amount	], 200);
    }

    public function capacity(Request $request) {
        $capacity = ShowTime::with('seats')->find($request->id);
        $count = 0;
        foreach ($capacity->seats as $seat) {
            if ($seat->available == false) {
                $count++;
            }
        }
        return response()->json(['capacity' => $capacity->seats->count(),'usage' => $count, 'available' => $capacity->seats->count() - $count ], 200);
    }

    public function reservations() {
        $reservations = Reservation::with('seat.showTime.movie')->where('status', 'confirmed')->get();
        return response()->json($reservations, 200);
    }

    public function reservationsByMovie(Request $request)
    {
        $reservations = Reservation::with('seat.showTime.movie')->whereHas('seat.showTime.movie', function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->title . '%');
        })->where('status', 'confirmed')->get();
        return response()->json($reservations, 200);
    }

    public function givePermission(Request $request) {
        $user = User::find($request->id);
        $user->assignRole('admin');
        return response()->json(['message' => 'Permission granted'], 200);
    }
}
