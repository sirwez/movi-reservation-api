<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run()
    {
        Movie::create([
            'title' => 'The Matrix',
            'description' => 'A computer hacker learns about the true nature of reality.',
            'image' => 'matrix.jpg',
            'genre' => 'Sci-Fi',
            'duration' => '2h 30m',
        ]);

        Movie::create([
            'title' => 'Inception',
            'description' => 'A thief who steals corporate secrets through dream-sharing technology.',
            'image' => 'inception.jpg',
            'genre' => 'Sci-Fi',
            'duration' => '2h 28m',
        ]);
    }
}
