<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Slot;
use App\Models\Ticket;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function addCheckIn(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'phone' => ['required','numeric','digits:10'],
            'type' => 'required',
            'license_plate' => 'required',
            'model' => 'required',
            'color' => 'required',
            'date' => 'required',
            'check-in' => 'required'
        ]);
        
        switch($formFields['type']){
            case 'car':
                $request->validate(['car_slot_number' => 'required']);
                $slotNumber = $request->car_slot_number;
                break;
            case 'van':
                $request->validate(['van_slot_number' => 'required']);
                $slotNumber = $request->van_slot_number;
                break;
            default:
                $request->validate(['motorbike_slot_number' => 'required']);
                $slotNumber = $request->motorbike_slot_number;
        }
        // Search for an existing customer with the same name and phone number
        $existingCustomer = Customer::where('phone', $formFields['phone'])->first();
        if ($existingCustomer) {
            $customer = $existingCustomer;
        } else {
            // Create a new customer since no matching customer was found
            $customer = Customer::create([
                'name' => $formFields['name'],
                'phone' => $formFields['phone']
            ]);
        }

        // Check if a vehicle with the same license plate already exists
        $existingVehicle = Vehicle::where('license_plate', $formFields['license_plate'])->first();

        if ($existingVehicle) {
            $vehicle = $existingVehicle;
        } else {
            // Create a new vehicle since no matching vehicle was found
            $vehicle = Vehicle::create([
                'license_plate' => $formFields['license_plate'],
                'type' => $formFields['type'],
                'model' => $formFields['model'],
                'color' => $formFields['color']
            ]);
        }

        $slot = Slot::where('number',$slotNumber)->first();
        $slot->status = 'occupied';
        $slot->save();

        $ticket = Ticket::create([
            'date'=>$formFields['date'],
            'check_in'=>$formFields['check-in'],
            'check_out'=>null,
            'payment_status'=>'unpaid',
            'payment_method'=>null,
            'vehicle_id'=> $vehicle->id,
            'slot_id'=> $slot->id,
            'customer_id'=> $customer->id,
            'user_id'=> auth()->id()
        ]);

        if($ticket){
            return back()->with('success', 'The vehicle has been checked in successfuly');
        }else{
            return back()->withInput()->with('fail', 'Something went wrong');
        }
    }

    public function printSlip(Ticket $ticket){
        $html = view('parking-slip', ['ticket' => $ticket])->render();
        return response($html)->header('Content-Type', 'text/html');
    }

    public function updateCheckOut(Ticket $ticket, Request $request){
        $formFields = $request->validate([
            'paymentMethod' => 'required'
        ]);

        if($ticket){
            $ticket->check_out = Carbon::now()->toTimeString();
            $ticket->payment_method = $formFields['paymentMethod'];
            $ticket->payment_status = 'paid';
            $ticket->save();

            $slot = Slot::where('number',$ticket->slot->number)->first();
            $slot->status = 'available';
            $slot->save();

            return back()->with('success', 'The vehicle has been checked out successfuly');
        }else{
            return back()->withInput()->with('fail', 'Something went wrong, invalid value');
        }
    }
    
    public function filter(Request $request){
        $formFields = $request->validate([
            'match' => 'required',
            'value' => 'required'
        ]);
        switch($formFields['match']){
            case 'id':
                $checkedIns = Ticket::where($formFields['match'], $formFields['value'])->get();
                break;
            case 'number':
                $checkedIns = Ticket::whereHas('slot', function ($query) use ($formFields) {
                    $query->where($formFields['match'], $formFields['value']);
                })->where('check_out', null)->get();
                break;
            case 'license_plate':
                $checkedIns = Ticket::whereHas('vehicle', function ($query) use ($formFields) {
                    $query->where($formFields['match'], $formFields['value']);
                })->where('check_out', null)->get();
                break;
            default:
            $checkedIns = Ticket::whereHas('customer', function ($query) use ($formFields) {
                $query->where($formFields['match'], $formFields['value']);
            })->where('check_out', null)->get();
        }
        if($checkedIns){
            return view('check-out', ['checkedIns' => $checkedIns]);
        }else{
            return back()->withInput()->with('fail', 'Something went wrong, invalid value');
        }
    }

    public function editCheckOut(Ticket $ticket){
        $checkIn = Carbon::parse($ticket->check_in);
        $currentTime = Carbon::now();
        $timeDifferenceInHours = $currentTime->diffInRealHours($checkIn);
        return view('editCheckOut', ['ticket' => $ticket, 'timeDifferenceInHours' => $timeDifferenceInHours]);
    }

    public function sort(Request $request){
        $sortBy = $request->input('sortType', 'number');
        $parkinglot_id = auth()->user()->parkinglot_id;
        $tickets = Ticket::whereHas('user', function ($query) use ($parkinglot_id) {
            $query->where('parkinglot_id', $parkinglot_id);
        })->latest()->get();
        if ($request->from and $request->to){
            $tickets = Ticket::whereBetween('created_at', [$request->from, $request->to])->get();
        }
        switch($sortBy){
            case 'number':
                $tickets = $tickets->sortBy('slot.number');
                break;
            case 'name':
                $tickets = $tickets->sortBy('customer.name');
                break;
            case 'date':
                $tickets = $tickets->sortBy(function ($ticket) {
                    return $ticket->date;
                });
                break;
            case 'duration':
                $tickets = $tickets->sortBy(function ($ticket) {
                    return $ticket->created_at->diffInHours($ticket->updated_at);
                });
                break;
            default:
                $tickets = $tickets->sortBy(function ($ticket) {
                    $durationHours = $ticket->created_at->diffInHours($ticket->updated_at);
                    $ratePerHour = $ticket->slot->rate;
                    return $durationHours * $ratePerHour;
                });
        }
        
        return view('history-sort',  ['tickets' => $tickets]);
    }

}
