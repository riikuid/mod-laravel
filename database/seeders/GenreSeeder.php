<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Action',
            'Adventure',
            'Animation',
            'Biographical',
            'Comedy',
            'Crime',
            'Disaster',
            'Documentary',
            'Drama',
            'Family',
            'Fantasy',
            'Fantasy Adventure',
            'Film Noir',
            'Historical',
            'Horror',
            'Martial Arts',
            'Musical',
            'Mystery',
            'Political Drama',
            'Post-Apocalyptic',
            'Psychological Thriller',
            'Romance',
            'Science Fiction',
            'Sports',
            'Spy',
            'Superhero',
            'Suspense',
            'Thriller',
            'War',
            'Western'

        ];

        // Loop melalui daftar genre dan masukkan ke dalam tabel
        foreach ($genres as $genre) {
            DB::table('movie_genres')->insert(['name' => $genre]);
        }
    }
}
