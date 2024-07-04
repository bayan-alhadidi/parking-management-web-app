<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Ticket;
use App\Models\Slot;
use App\Models\User;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get available vehicle IDs
        $vehicleIds = DB::table('vehicles')->pluck('id')->toArray();

        // Get available customer IDs
        $customerIds = DB::table('customers')->pluck('id')->toArray();

        // Define date range
        $startDate = now()->startOfMonth()->addDays(-1); // Start from the end of the previous month
        $endDate = now()->endOfMonth(); // End of the current month

        // Iterate through the date range
        while ($startDate->lte($endDate)) {

            // Get available slots for a specific parking lot (assuming $parkinglot_id is set)
            $parkinglot_id = 2; // Replace with the specific parking lot ID

            // Retrieve slots and users associated with the parking lot
            $slots = Slot::where('parkinglot_id', $parkinglot_id)->pluck('id')->toArray();
            $users = User::where('parkinglot_id', $parkinglot_id)->pluck('id')->toArray();

            for ($i = 0; $i < 20; $i++) {
                $checkInTime = $startDate->copy()->addHours(random_int(1, 12));
                $checkOutTime = $checkInTime->copy()->addHours(random_int(1, 6));

                $ticketDate = $startDate->format('Y-m-d');
                $ticketCheckInTime = $checkInTime->format('H:i:s');
                $ticketCheckOutTime = $checkOutTime->format('H:i:s');

                Ticket::create([
                    'date' => $ticketDate,
                    'check_in' => $ticketCheckInTime,
                    'check_out' => $ticketCheckOutTime,
                    'payment_status' => 'paid',
                    'payment_method' => $faker->randomElement(['credit card', 'cash', 'mobile payments']),
                    'vehicle_id' => $faker->randomElement($vehicleIds),
                    'slot_id' => $faker->randomElement($slots),
                    'customer_id' => $faker->randomElement($customerIds),
                    'user_id' => $faker->randomElement($users),
                    'created_at' => $ticketDate . ' ' . $ticketCheckInTime,
                    'updated_at' => $ticketDate . ' ' . $ticketCheckOutTime,
                ]);
            }

            $startDate->addDay();
        }
    }
}
