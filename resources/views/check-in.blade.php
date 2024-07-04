@php
use Carbon\Carbon;
@endphp
@extends('layout')
@section('title','Check-In')
@section('sidenav')
<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu brown pt-5">
      <div class="nav pt-3 link-wrapper">
        <a class="nav-link" href="/dashboard"><i class="fas fa-tachometer-alt"></i><span class="mx-2"></span>
          Dashboard</a>
        <a class="nav-link" href="/history"><i class="fas fa-book-open"></i><span class="mx-2"></span>
          History</a>
        <hr class="custom-divider my-4" />
        <p class="text-white-50 ms-3">Tickets</p>
        <a class="nav-link link-active pointer"><i class="fa-solid fa-ticket"></i>
          <span class="mx-2"></span> Check In</a>
        <a class="nav-link" href="/check-out"><i class="fa-regular fa-credit-card"></i><span
            class="mx-2"></span>
          Check Out</a>
        <hr class="custom-divider my-4" />
        <a class="nav-link" href="/map"><i class="fa-solid fa-suitcase"></i><span class="mx-2"></span>
          Parking Map</a>
        <a class="nav-link" href="/setting"><i class="fa-solid fa-gear"></i><span class="mx-2"></span>
          Parking
          Settings</a>
      </div>
    </div>
  </nav>
</div>
@endsection
@section('body')
<main class="shade flex-1 py-5 container-fluid wide check-in">
  <h4 class="mb-5 text-center text-black-50">Check-In</h4>
  <form class="mx-md-3 text-center" method="POST" action="/add-check-in">
    @csrf
    @if(Session::has('success'))
    <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if(Session::has('fail'))
    <div class="alert alert-danger">{{Session::get('fail')}}</div>
    @endif
    <h5 class="mb-3 text-center text-black-50">Customer</h5>
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="customerName" type="text" name="name" value="{{old('name')}}"/>
        <label class="ps-4 text-black-50" for="customerName">Customer Name</label>
        <span class="text-danger">@error('name') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="customerPhone" type="text" name="phone" value="{{old('phone')}}"/>
        <label class="ps-4 text-black-50" for="customerPhone">Customer Phone</label>
        <span class="text-danger">@error('phone') {{$message}} @enderror</span>
      </div>
    </div>
    <hr class="w-75 m-auto my-3">
    <h5 class="mb-3 text-center text-black-50">Vehicle</h5>
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" name="type" id="vehicleType" >
          <option value="car">Car</option>
          <option value="van">Van</option>
          <option value="motorbike">Motorbike</option>
        </select>
        <span class="text-danger">@error('type') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="licensePlate" type="text" name="license_plate" value="{{old('license_plate')}}"/>
        <label class="ps-4 text-black-50" for="licensePlate">License Plate</label>
        <span class="text-danger">@error('license_plate') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="vehicleModle" type="text" name="model" value="{{old('model')}}"/>
        <label class="ps-4 text-black-50" for="vehicleModle">Vehicle Model</label>
        <span class="text-danger">@error('model') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="vehicleColor" type="text" name="color" value="{{old('color')}}"/>
        <label class="ps-4 text-black-50" for="vehicleColor">Vehicle Color</label>
        <span class="text-danger">@error('color') {{$message}} @enderror</span>
      </div>
    </div>
    <hr class="w-75 m-auto my-3">
    <h5 class="mb-3 text-center text-black-50">Available Slots</h5>
    <div class="row justify-content-center py-3 w-100 m-auto">

      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6" id="elementToToggle1" style="display: block;">
        <input class="form-control needChecking" type="text" name="car_slot_number" id="slotNumber" 
        value="{{$availableCarSlot ? $availableCarSlot->number : ''}}" readonly/>
        <label class="ps-4 text-black-50" for="car_slot_number">Slot Number</label>
      </div>

      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6" id="elementToToggle2" style="display: none;">
        <input class="form-control needChecking" type="text" name="van_slot_number" id="slotNumber" 
        value="{{$availableVanSlot ? $availableVanSlot->number : ''}}" readonly/>
        <label class="ps-4 text-black-50" for="van_slot_number">Slot Number</label>
      </div>

      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6" id="elementToToggle3" style="display: none;">
        <input class="form-control needChecking" type="text" name="motorbike_slot_number" id="slotNumber" 
        value="{{$availableBikeSlot ? $availableBikeSlot->number : ''}}" readonly/>
        <label class="ps-4 text-black-50" for="motorbike_slot_number">Slot Number</label>
      </div>

      <span class="text-danger">@error('car_slot_number') {{$message}} @enderror</span>
      <span class="text-danger">@error('van_slot_number') {{$message}} @enderror</span>
      <span class="text-danger">@error('motorbike_slot_number') {{$message}} @enderror</span>
    </div>
    <hr class="w-75 m-auto my-3">
    <h5 class="mb-3 text-center text-black-50">Enterence</h5>
    <div class="row justify-content-center py-3 w-100 m-auto">
      @php
      $currentTime = Carbon::now();
      $date = $currentTime->format('Y-m-d');
      $time = $currentTime->format('H:i:s');
      @endphp
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="enterDate" type="text" name="date" value="{{$date}}" readonly/>
        <label class="ps-4 text-black-50" for="enterDate">Enterence Date</label>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="enterTime" type="text" name="check-in" value="{{$time}}" readonly/>
        <label class="ps-4 text-black-50" for="enterTime">Enterence Time</label>
      </div>
    </div>
    <input class="btn btn-cta w-180px" type="submit" value="Check In">
  </form>
  <h5 class="mt-5 text-center text-black-50">Checked-In Vehicles</h5>
  <table id="checkInTable"
    class="m-auto mt-3 text-center table table-bordered responsive table-responsive table-hover mb-0 bg-light">
    <thead>
      <tr>
        <th>Ticket ID</th>
        <th>Slot Number</th>
        <th>Vehicle Type</th>
        <th>Vehicle Plate</th>
        <th>Customer Name</th>
        <th><span class="nowrap">Check-In</span><br>Date</th>
        <th><span class="nowrap">Check-In</span><br>Time</th>
        <th>Print</th>
      </tr>
    </thead>
    <tbody class="bg-white">

      @foreach ($checkedIns as $checkedIn)
      <tr>
        <td>{{$checkedIn->id}}</td>
        <td>{{$checkedIn->slot->number}}</td>
        <td>{{$checkedIn->vehicle->type}}</td>
        <td>{{$checkedIn->vehicle->license_plate}}</td>
        <td>{{$checkedIn->customer->name}}</td>
        <td>{{$checkedIn->date}}</td>
        <td>{{$checkedIn->check_in}}</td>
        <td><a onclick="printParkingSlip({{$checkedIn->id}})" class="btn btn-brown"><i class="fa fa-print"></i></a></td>
      </tr>
      @endforeach
      
    </tfoot>
  </table>
</main>
@endsection