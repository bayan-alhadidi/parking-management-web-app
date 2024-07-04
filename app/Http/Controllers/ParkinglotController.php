<?php

namespace App\Http\Controllers;

use App\Models\Parkinglot;
use Exception;
use Illuminate\Http\Request;

class ParkinglotController extends Controller
{
    public function setParkinglot(Parkinglot $parkinglot, Request $request){
        $parkinglot->parking_name = $request->parking_name;
        $parkinglot->address = $request->address;
        try{
            $parkinglot->save();
            if($parkinglot){
                return back()->with('parkinglotSuccess', 'The parking lot data has been saved successfuly');
            }else{
                return back()->withInput()->with('parkinglotFail', 'Something went wrong');
            }
        }catch(Exception $e){
            return back()->withInput()->with('parkinglotFail', $e->getMessage());
        }
    }
    public function closeParkinglot(Parkinglot $parkinglot){
        $parkinglot->status = 'closed';
        try{
            $parkinglot->save();
            if($parkinglot){
                return redirect('/?overlay=login')->with('loginSuccess', 'The parking lot has been closed successfuly');
            }else{
                return back()->withInput()->with('parkinglotFail', 'Something went wrong');
            }
        }catch(Exception $e){
            return back()->withInput()->with('parkinglotFail', $e->getMessage());
        }
    }
}
