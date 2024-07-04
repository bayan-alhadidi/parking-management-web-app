<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SlotController extends Controller
{
    public function addSlot(Request $request) {
        $formFields = $request->validate([
            'number' => ['required',Rule::unique('slots', 'number')],
            'type' => 'required',
            'rate' => ['required','numeric']
        ]);
        $formFields['number'] = strip_tags($formFields['number']);
        $formFields['type'] = strip_tags($formFields['type']);
        $formFields['rate'] = strip_tags($formFields['rate']);
        $formFields['status'] = 'available';
        $formFields['parkinglot_id'] = auth()->user()->parkinglot_id;
        try{
            $slot = Slot::create($formFields);
            if($slot){
                return back()->with('slotSuccess', 'New slot has been added successfuly');
            }else{
                return back()->withInput()->with('slotFail', 'Something went wrong');
            }
        }catch(Exception $e){
            return back()->withInput()->with('slotFail', $e->getMessage());
        }
    }

    public function editSlot(Slot $slot, Request $request) {
        $formFields = $request->validate([
            'number' => ['required', Rule::unique('slots', 'number')->ignore($slot->id)],
            'type' => 'required',
            'rate' => ['required','numeric']
        ]);
        $formFields['number'] = strip_tags($formFields['number']);
        $formFields['type'] = strip_tags($formFields['type']);
        $formFields['rate'] = strip_tags($formFields['rate']);
        $formFields['status'] = 'available';
        try{
            $slot->update($formFields);
            if($slot){
                return back()->with('slotSuccess', 'The slot has been updated successfuly');
            }else{
                return back()->withInput()->with('slotFail', 'Something went wrong');
            }
        }catch(Exception $e){
            return back()->withInput()->with('slotFail', $e->getMessage());
        }
    }

    public function getEditSlot(Slot $slot){
        try{
            $parkinglot_id = auth()->user()->parkinglot_id;
            $slots = Slot::where('parkinglot_id', $parkinglot_id)->orderBy('number')->get();
            return view('editSlot', ['slots' => $slots,'slot' => $slot]);
        }catch(Exception $e){
            return back()->withInput()->with('slotFail', $e->getMessage());
        }
    }

    public function deleteSlot(Slot $slot) {
        try {
            $tickets = Ticket::where('slot_id', $slot->id)->get();
    
            if ($tickets->isEmpty()) {
                $slot->delete();
                return $this->slotDeletedResponse($slot);
            }
    
            $firstSlot = Slot::where('id', '!=', $slot->id)->first();
    
            if ($firstSlot) {
                foreach ($tickets as $ticket) {
                    $ticket->update(['slot_id' => $firstSlot->id]);
                }
    
                $slot->delete();
                return $this->slotDeletedResponse($slot);
            } else {
                return back()->withInput()->with('slotFail', 'Sorry, this slot cannot be deleted');
            }
        } catch (Exception $e) {
            return back()->withInput()->with('slotFail', $e->getMessage());
        }
    }

    private function slotDeletedResponse($slot) {
        if ($slot) {
            return back()->with('slotSuccess', 'The slot has been deleted successfully');
        } else {
            return back()->withInput()->with('slotFail', 'Something went wrong');
        }
    }
}
