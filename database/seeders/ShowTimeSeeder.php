<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShowTime;
use App\Models\Movie;

class ShowTimeSeeder extends Seeder
{
    public function run()
    {
        $movies = Movie::all(); // Recupera os filmes criados no MovieSeeder

        foreach ($movies as $movie) {
            ShowTime::create([
                'show_time' => '18:00',
                'room' => 'Room 1',
                'date' => now()->addDays(1),
                'price' => 20.00,
                'total_seats' => 100,
                'movie_id' => $movie->id,
            ]);

            ShowTime::create([
                'show_time' => '20:30',
                'room' => 'Room 2',
                'date' => now()->addDays(1),
                'price' => 25.00,
                'total_seats' => 100,
                'movie_id' => $movie->id,
            ]);
        }
    }
}
