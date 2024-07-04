@php
use Carbon\Carbon;
@endphp
@extends('layout')
@section('title','History')
@section('sidenav')
<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu brown pt-5">
      <div class="nav pt-3 link-wrapper">
        <a class="nav-link" href="/dashboard"><i class="fas fa-tachometer-alt"></i><span class="mx-2"></span>
          Dashboard</a>
        <a class="nav-link link-active pointer"><i class="fas fa-book-open"></i><span class="mx-2"></span>
          History</a>
        <hr class="custom-divider my-4" />
        <p class="text-white-50 ms-3">Tickets</p>
        <a class="nav-link" href="/check-in"><i class="fa-solid fa-ticket"></i>
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
<main class="shade flex-1 py-5 container-fluid wide history">
  <h4 class="mb-5 text-center text-black-50">History</h4>
  <form method="GET" action="/history/sort">
    @csrf
    <h5 class="mx-3 mb-2 text-black-50 w-auto">Sort history content by the...</h5>
    <div class="row justify-content-center w-100 m-auto">
      <div class="text-center">
        <select id="sortType" class="col-sm-10 col-md-8 col-lg-6 select-style" name="sortType" >
          <option value="number">Slot Number</option>
          <option value="name">Customer Name</option>
          <option value="date">Check-In Date</option>
          <option value="duration">Parking Duration</option>
          <option value="total">Total Charge</option>
        </select>
      </div>
      <input class="mt-3 reversed w-180px mx-20perc" type="submit" value="Sort">
      <hr class="w-75 m-auto my-3">
    </div>
    <h5 class="mx-3 mb-2 text-black-50 w-auto">Show history for a time span</h5>
    <div class="row justify-content-center w-100 m-auto">
      <div class=" form-floating pe-sm-1 mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="dateFrom" type="date" name="from" />
        <label class="ps-4 text-black-50" for="dateFrom">Select Date From</label>
      </div>
      <div class=" form-floating ps-sm-1 mb-3 col-12 col-sm-6 col-lg-6" id="date2Box">
        <input class="form-control needChecking" id="dateTo" type="date" name="to" />
        <label class="ps-4 text-black-50" for="dateTo">Select Date To</label>
      </div>
      <input class="reversed w-180px mx-20perc" type="submit" value="Show">
      <hr class="w-75 m-auto my-3">
    </div>
  </form>
  <div class="table mb-0">
    <table id="historyTable"
      class="text-center m-auto table table-bordered table-responsive table-hover mb-0 bg-light">
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
          <th>Payment Status</th>
          <th>Payment Method</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        @foreach( $tickets as $ticket)
        @php
        $durationHours = $ticket->created_at->diffInHours($ticket->updated_at);
        $ratePerHour = $ticket->slot->rate;
        $total = $durationHours * $ratePerHour;
        @endphp
        <tr>
          <td>{{$ticket->id}}</td>
          <td>{{$ticket->slot->number}}</td>
          <td>{{$ticket->vehicle->type}}</td>
          <td>{{$ticket->vehicle->license_plate}}</td>
          <td>{{$ticket->customer->name}}</td>
          <td>{{$ticket->date}}</td>
          <td>{{$ticket->check_in}}</td>
          <td>{{$ticket->check_out}}</td>
          <td>{{$durationHours}} Hour</td>
          <td>{{$total}} $</td>
          <td>{{$ticket->payment_status}}</td>
          <td>{{$ticket->payment_method}}</td>
        </tr>
        @endforeach

        </tfoot>
    </table>
  </div>
</main>
@endsection