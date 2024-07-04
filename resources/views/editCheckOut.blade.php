@php
use Carbon\Carbon;
@endphp
@extends('layout')
@section('title','Check-Out')
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
        <a class="nav-link" href="/check-in"><i class="fa-solid fa-ticket"></i>
          <span class="mx-2"></span> Check In</a>
        <a class="nav-link link-active pointer" href="/check-out"><i class="fa-regular fa-credit-card"></i><span
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
<main class="shade flex-1 py-5 container-fluid wide check-out">
  <h4 class="mb-5 text-center text-black-50">Check-Out</h4>
  <form class="mx-md-3 text-center" method="POST">
    @csrf
    @if(Session::has('success'))
    <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if(Session::has('fail'))
    <div class="alert alert-danger">{{Session::get('fail')}}</div>
    @endif
    <hr class="w-75 m-auto my-3">
    <label class="mt-4 text-black-50" for="enterDate">Vehicle INFO</label>
    <table id="checkOutTable"
      class="m-auto text-center table table-bordered responsive table-responsive table-hover mb-0 bg-light">
      <thead>
        <tr>
          <th>Ticket ID</th>
          <th>Slot Number</th>
          <th>Vehicle Type</th>
          <th>Vehicle Plate</th>
          <th>Customer Name</th>
          <th><span class="nowrap">Check-In</span><br>Date</th>
          <th><span class="nowrap">Check-In</span><br>Time</th>
          <th><span class="nowrap">Check-Out</span><br>Time</th>
          <th>Parking Duration</th>
          <th>Total Charge</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <tr>
          <td>{{$ticket->id}}</td>
          <td>{{$ticket->slot->number}}</td>
          <td>{{$ticket->vehicle->type}}</td>
          <td>{{$ticket->vehicle->license_plate}}</td>
          <td>{{$ticket->customer->name}}</td>
          <td>{{$ticket->date}}</td>
          <td>{{$ticket->check_in}}</td>
          @php
          $currentTime = Carbon::now();
          $time = $currentTime->format('H:i:s');
          $ratePerHour = $ticket->slot->rate;
          $total = $timeDifferenceInHours * $ratePerHour;
          @endphp
          <td>{{$time}}</td>
          <td>{{$timeDifferenceInHours}} Hour</td>
          <td>{{$total}} $</td>
        </tr>
        </tfoot>
      </table>
      <label class="mt-5 text-black-50" for="enterDate">Payment Method</label>
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class="mt-0 form-floating my-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" id="paymentMethod" name="paymentMethod" value="{{old('paymentMethod')}}">
          <option name="tag" value="cash">cash</option>
          <option name="tag" value="credit card">credit card</option>
          <option name="tag" value="mobile payments">mobile payments</option>
        </select>
        <span class="text-danger">@error('paymentMethod') {{$message}} @enderror</span>
      </div>
    </div>
    <hr class="w-75 m-auto my-3">
    @method('PUT')
    <input class="btn btn-cta w-180px" type="submit" value="Check Out" formaction="/update-check-out/{{$ticket->id}}">
  </form>
</main>
@endsection