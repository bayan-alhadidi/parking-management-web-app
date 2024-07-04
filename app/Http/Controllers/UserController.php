<?php

namespace App\Http\Controllers;

use App\Models\Parkinglot;
use App\Models\Ticket;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request){
        
        $formFields = $request -> validate([
            'login_email' => ['required', 'email'],
            'login_password' => ['required', 'min:8', 'max:15']
        ]);
        try{
            if(Auth::attempt(['email'=> $formFields['login_email'], 'password'=> $formFields['login_password']])){
                if(auth()->user()->parkinglot->status == 'active'){
                    return redirect()->intended('/dashboard');
                }
                else{
                    return back()->withInput()->with('loginFail', 'the parking lot is closed');
                }
            }
            return back()->withInput()->with('loginFail', 'Invalid credentials');
        }catch(Exception $e){
            return back()->withInput()->with('loginFail', $e->getMessage());
        }
    }

    public function logout(Request $request){
        auth()->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/?overlay=login')->with('loginSuccess', 'You have been logged out!');
    }

    public function register(Request $request){
        $formFields = $request -> validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:15'],
            'confirm-password' => ['required', 'same:password']
        ]);
        $formFields['password'] = bcrypt(($formFields['password']));
        $formFields['role_id'] = 1;
        try{
            $parkinglot = Parkinglot::create();
            $formFields['parkinglot_id'] = $parkinglot->id;
            $user = User::create($formFields);
            if($user){
                // Automatically log in the admin after successful registration
                Auth::login($user);
                return redirect('/setting');
            }else{
                return back()->withInput()->with('registerFail', 'Something went wrong');
            }
        }catch(Exception $e){
            return back()->withInput()->with('registerFail', $e->getMessage());
        }
    }

    public function loginform(){
        return redirect('/?overlay=login')->with('loginFail', 'You have to login first.');
    }
    public function signupform(){
        return redirect('/?overlay=signup');
    }

    public function addEmployee(Request $request){
        $formFields = $request -> validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:15'],
            'confirm-password' => ['required', 'same:password'],
            'shift' => 'required'
        ]);
        $formFields['password'] = bcrypt(($formFields['password']));
        $formFields['parkinglot_id'] = auth()->user()->parkinglot_id;
        
        switch($formFields['shift']){
            case 'admin':
                $formFields['role_id'] = 1;
                break;
            case 'morning':
                $formFields['role_id'] = 2;
                break;
            case 'evening':
                $formFields['role_id'] = 3;
                break;
            case 'midnight':
                $formFields['role_id'] = 4;
                break;
            default:
                $formFields['role_id'] = 1;
        }
        try{
            $user = User::create($formFields);
            if($user){
                return back()->with('employeeSuccess', 'New employee has been added successfuly');
            }else{
                return back()->withInput()->with('employeeFail', 'Something went wrong');
            }
        }catch(Exception $e){
            return back()->withInput()->with('employeeFail', $e->getMessage());
        }
    }

    public function deleteEmployee(User $user) {
        try{
            if($user->role_id === 1){
                return back()->with('employeeFail', 'Admin can not be deleted');
            }
            $tickets = Ticket::where('user_id', $user->id)->get();
    
            if ($tickets->isEmpty()) {
                $user->delete();
                return $this->userDeletedResponse($user);
            }
            $parkinglot_id = auth()->user()->parkinglot_id;
            $admin = User::where('role_id', 1)->where('parkinglot_id', $parkinglot_id)->first();
            foreach ($tickets as $ticket) {
                $ticket->update(['user_id' => $admin->id]);
            }

            $user->delete();
            return $this->userDeletedResponse($user);

        }catch(Exception $e){
            return back()->withInput()->with('employeeFail', $e->getMessage());
        }
    }

    private function userDeletedResponse($user) {
        if($user){
            return back()->with('employeeSuccess', 'The employee has been deleted successfuly');
        }else{
            return back()->withInput()->with('employeeFail', 'The entered ID is incorrect');
        }
    }
}
