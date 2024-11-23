<?php

namespace App\Observers;

use App\Models\Seat;
use App\Models\ShowTime;
use App\Services\SeatService;

class ShowTimeObserver
{
    /**
     * Handle the ShowTime "created" event.
     */
    public function created(ShowTime $showTime): void
    {
        (new SeatService())->createSeats($showTime->id, $showTime->total_seats);
    }

    /**
     * Handle the ShowTime "updated" event.
     */
    public function updated(ShowTime $showTime): void
    {
        //
    }

    /**
     * Handle the ShowTime "deleted" event.
     */
    public function deleted(ShowTime $showTime): void
    {
        //
    }

    /**
     * Handle the ShowTime "restored" event.
     */
    public function restored(ShowTime $showTime): void
    {
        //
    }

    /**
     * Handle the ShowTime "force deleted" event.
     */
    public function forceDeleted(ShowTime $showTime): void
    {
        //
    }
}
