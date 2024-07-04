<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Vehicle;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $vehicleTypes = ['van', 'car', 'motorbike'];

        for ($i = 0; $i < 100; $i++) {
            $licensePlate = $faker->unique()->randomNumber(4);
            $vehicleModel = $faker->word; // Generate a random word as the vehicle model
            $color = $faker->colorName();

            Vehicle::create([
                'license_plate' => $licensePlate,
                'type' => $faker->randomElement($vehicleTypes),
                'model' => $vehicleModel,
                'color' => $color,
            ]);
        }
    }
}
