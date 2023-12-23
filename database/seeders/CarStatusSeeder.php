<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('car_statuses')->insert([
            'id' => 1,
            'temperature' => '37 C',
            'origin' => 'Surabaya Gubeng (SGU)',
            'destination' => 'Madiun (MDN)',
            'next_station' => 'Wonokromo (WO) cuy',
        ]);
    }
}
