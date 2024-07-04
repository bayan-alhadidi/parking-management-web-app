<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ParkinglotController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Authentication Routes
Auth::routes();

//page routes
Route::get('/', [PageController::class, 'home']);
Route::get('/dashboard', [PageController::class, 'dashboard'])->middleware('auth');
Route::get('/history', [PageController::class, 'history'])->middleware('auth');
Route::get('/check-in', [PageController::class, 'checkin'])->middleware('auth');
Route::get('/check-out', [PageController::class, 'checkout'])->middleware('auth');
Route::get('/map', [PageController::class, 'map'])->middleware('auth');

//user routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/loginform', [UserController::class, 'loginform'])->name('login')->middleware('guest');
Route::get('/signupform', [UserController::class, 'signupform'])->middleware('guest');

//ticket routes
Route::post('/add-check-in', [TicketController::class, 'addCheckIn'])->middleware('auth');
Route::put('/update-check-out/{ticket}', [TicketController::class, 'updateCheckOut'])->middleware('auth');
Route::get('/edit-check-out/{ticket}', [TicketController::class, 'editCheckOut'])->middleware('auth');
Route::post('/check-out/filter', [TicketController::class, 'filter'])->middleware('auth');
Route::get('/print-slip/{ticket}', [TicketController::class, 'printSlip'])->middleware('auth');
Route::get('/history/sort', [TicketController::class, 'sort'])->middleware('auth');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/setting', [PageController::class, 'setting'])->middleware('auth');
    Route::put('/set-parkinglot/{parkinglot}', [ParkinglotController::class, 'setParkinglot'])->middleware('auth');
    Route::put('/closeParkinglot/{parkinglot}', [ParkinglotController::class, 'closeParkinglot'])->middleware('auth');
    Route::post('/add-employee', [UserController::class, 'addEmployee'])->middleware('auth');
    Route::get('/delete-employee/{user}', [UserController::class, 'deleteEmployee'])->middleware('auth');

    //slot routes
    Route::post('/add-slot', [SlotController::class, 'addSlot'])->middleware('auth');
    Route::get('/edit-slot/{slot}', [SlotController::class, 'getEditSlot'])->middleware('auth');
    Route::put('/edit-slot/{slot}', [SlotController::class, 'editSlot'])->middleware('auth');
    Route::get('/delete-slot/{slot}', [SlotController::class, 'deleteSlot'])->middleware('auth');
});
