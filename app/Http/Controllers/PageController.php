<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;

class PageController extends Controller
{
    public function home(){
        return view('home');
    }

    public function dashboard(){
        $parkinglot_id = auth()->user()->parkinglot_id;
        // Initialize an array to store monthly totals
        $monthlyTotals = [];
        $dailyTotalsForMonth = [];
        $dailyTotalsForWeek = [];
        $hourlyTotals = [];
        $currentYear = Carbon::now()->year;
        $currentDateTime = Carbon::now();
        $startDate = Carbon::create($currentYear, 1, 1, 0, 0, 0);
        $endDate = Carbon::create($currentYear, 12, 31, 23, 59, 59);
        // Get all tickets with their associated slots for a specific time range (e.g., a year)
        $tickets = Ticket::with('slot')
        ->whereBetween('date', [$startDate, $endDate])
        ->whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->get();

        // Loop through each ticket and calculate the rate for each month
        foreach ($tickets as $ticket) {
            $date = Carbon::parse($ticket->date);
            $month = $date->format('F Y'); // This will give you something like 'September 2023'
            $day = $date->format('Y-m-d');
            $dayOfMonth = $date->day;
            $weekInMonth = ceil($date->day / 7);// Week number from 1 to 4 within the current month
            $year = $date->format('Y');
            $formattedHour = $date->format('g A');// Example output: '3 PM'

            // Calculate the rate for the ticket
            $ticketRate = $this->calculateTicketRate($ticket);

            
            if ($day === $currentDateTime->format('Y-m-d')) {
                // Use $formattedHour instead of $hour in the array key
                $hourlyTotals[$formattedHour] = ($hourlyTotals[$formattedHour] ?? 0) + $ticketRate;
            }

            
            if ($year === $currentDateTime->format('Y') && $weekInMonth === ceil($currentDateTime->day / 7)) {
                $dailyTotalsForWeek[$day] = ($dailyTotalsForWeek[$day] ?? 0) + $ticketRate;
            }

            
            if ($month === $currentDateTime->format('F Y')) {
                // Use $dayOfMonth instead of $day in the array key
                $dailyTotalsForMonth[$dayOfMonth] = ($dailyTotalsForMonth[$dayOfMonth] ?? 0) + $ticketRate;
            }
            
            $monthlyTotals[$month] = ($monthlyTotals[$month] ?? 0) + $ticketRate;
        }

        $paidTickets = Ticket::where('payment_status', 'Paid')
        ->whereIn('payment_method', ['credit card', 'cash', 'mobile payments'])
        ->whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->get();
        
        // Count occurrences of each payment method
        $paymentMethodCounts = $paidTickets->groupBy('payment_method')->map->count();

        // Calculate the date 24 hours ago from the current time
        $twentyFourHoursAgo = Carbon::now()->subHours(24);

        // Retrieve tickets created in the last 24 hours
        $last24tickets = Ticket::where('created_at', '>=', $twentyFourHoursAgo)->whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->get();

        // Retrieve vehicles IDs associated with the specific parking lot
        $vehiclesIDs = Ticket::whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->pluck('vehicle_id')->unique();

        // Get all vehicles with their associated tickets
        $vehicles = Vehicle::with('vehiclesTickets')->whereIn('id', $vehiclesIDs)->get(); 

        $averageDurations = [];

        foreach ($vehicles as $vehicle) {
            $totalDurationInHours = 0;
            $totalTickets = $vehicle->vehiclesTickets->count();

            // Calculate the total duration for this vehicle type in hours
            foreach ($vehicle->vehiclesTickets as $ticket) {
                $durationInHours = $ticket->created_at->diffInHours($ticket->updated_at);
                $totalDurationInHours += $durationInHours;
            }
            // Calculate the average duration in hours
            $averageDurationHours = ($totalDurationInHours) / ($totalTickets > 0 ? $totalTickets : 1);

            // Store the result in the array using the vehicle type as the key
            $averageDurations[$vehicle->type] = round($averageDurationHours, 2);
        }
        
        return view('dashboard', compact('monthlyTotals', 'dailyTotalsForMonth', 'dailyTotalsForWeek',
                    'hourlyTotals','paymentMethodCounts', 'last24tickets', 'averageDurations', 'parkinglot_id'));
    }

    public function history(){
        $parkinglot_id = auth()->user()->parkinglot_id;
        $tickets = Ticket::whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->latest()->get();
        return view('history', ['tickets' => $tickets]);
    }

    public function checkin(){
        $parkinglot_id = auth()->user()->parkinglot_id;
        $slotTypes = ['car', 'van', 'motorbike'];
        $availableSlots = [];

        foreach ($slotTypes as $type) {
            $availableSlot = Slot::where('status', 'available')
                ->where('type', $type)
                ->where('parkinglot_id', $parkinglot_id)
                ->orderBy('number')
                ->first();

            $availableSlots[$type] = $availableSlot;
        }
        $checkedIns = Ticket::where('check_out', null)->whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->latest()->get();
        return view('check-in', ['availableCarSlot' => $availableSlots['car'],
                                'availableVanSlot' => $availableSlots['van'],
                                'availableBikeSlot' => $availableSlots['motorbike'],
                                'checkedIns' => $checkedIns]);
    }

    public function checkout(){
        $parkinglot_id = auth()->user()->parkinglot_id;
        $checkedIns = Ticket::where('check_out', null)->whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->latest()->get();
        return view('check-out', ['checkedIns' => $checkedIns]);
    }

    public function map(){
        $parkinglot_id = auth()->user()->parkinglot_id;
        $availableSlots = Slot::where('status', 'available')->where('parkinglot_id', $parkinglot_id)->orderBy('number')->get();
        $occupiedSlots = Slot::where('status', 'occupied')->where('parkinglot_id', $parkinglot_id)->orderBy('number')->get();
        return view('map', ['availableSlots' => $availableSlots, 'occupiedSlots' => $occupiedSlots, 'parkinglot_id' => $parkinglot_id]);
    }

    public function setting(){
        $parkinglot_id = auth()->user()->parkinglot_id;
        $slots = Slot::where('parkinglot_id', $parkinglot_id)->orderBy('number')->get();
        $users = User::where('parkinglot_id', $parkinglot_id)->get();
        return view('setting', ['users' => $users,'slots' => $slots, 'parkinglot_id' => $parkinglot_id]);
    }
    // Helper function to calculate the ticket rate
    private function calculateTicketRate($ticket) {
        $durationHours = $ticket->created_at->diffInHours($ticket->updated_at);
        return $ticket->slot->rate * $durationHours;
    }
}
