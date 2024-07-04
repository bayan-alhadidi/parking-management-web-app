<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slot;

class SlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert 40 car slots for parking lot 1
        for ($i = 1; $i <= 40; $i++) {
            Slot::create([
                'number' => $i,
                'status' => 'available', 
                'type' => 'car',
                'rate' => 5.00, 
                'parkinglot_id' => 1, 
            ]);
        }

        // Insert 10 van slots for parking lot 1
        for ($i = 41; $i <= 50; $i++) {
            Slot::create([
                'number' => $i,
                'status' => 'available', 
                'type' => 'van',
                'rate' => 10.00, 
                'parkinglot_id' => 1, 
            ]);
        }

        // Insert 10 motorbike slots for parking lot 1
        for ($i = 51; $i <= 60; $i++) {
            Slot::create([
                'number' => $i,
                'status' => 'available', 
                'type' => 'motorbike',
                'rate' => 2.00,
                'parkinglot_id' => 1,
            ]);
        }

        // Insert 60 car slots for parking lot 2
        for ($i = 61; $i <= 100; $i++) {
            Slot::create([
                'number' => $i,
                'status' => 'available',
                'type' => 'car',
                'rate' => 5.00, 
                'parkinglot_id' => 2, 
            ]);
        }
    }
}
