<?php

namespace App\Http\Controllers;

use App\Models\ShowTime;
use Illuminate\Http\Request;

class ShowTimeController extends Controller
{
    public function index() {
        $showTimes = ShowTime::with('movie')->get();
        return response()->json($showTimes, 200);
    }
}
