@php use 
App\Models\Ticket;
@endphp
@extends('layout')
@section('title','Parking-Map')
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
        <a class="nav-link" href="/check-out"><i class="fa-regular fa-credit-card"></i><span
            class="mx-2"></span>
          Check Out</a>
        <hr class="custom-divider my-4" />
        <a class="nav-link link-active pointer"><i class="fa-solid fa-suitcase"></i><span class="mx-2"></span>
          Parking Map</a>
        <a class="nav-link" href="/setting"><i class="fa-solid fa-gear"></i><span class="mx-2"></span>
          Parking
          Settings</a>
      </div>
  </nav>
</div>
@endsection
@section('body')
<main class="shade flex-1 py-5 container-fluid wide map">
  <h4 class="mb-5 text-center text-black-50">Parking Slots Map</h4>
  <div class="row container-fluid m-0 p-0">
    <div class="col-xl-6 mb-5 mb-md-0">
      <h5 class="mb-3 text-center text-black-50">Available Slots</h5>
      <div class="table mb-0">
        <table id="mapTable1"
          class="p-0 container text-center table table-bordered sm-responsive table-responsive table-hover bg-light">
          <thead>
            <tr>
              <th>Slot Number</th>
              <th>Slot Type</th>
              <th>Slot Hour Rate</th>
              <th>Last<span class="nowrap">Check-In</span><br>Date</th>
              <th>Last<span class="nowrap">Check-In</span><br>Time</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            
            @foreach ($availableSlots as $availableSlot)
            <tr>
              <td>{{$availableSlot['number']}}</td>
              <td>{{$availableSlot['type']}}</td>
              <td>{{$availableSlot['rate']}} $</td>
              @php
              $ticket = Ticket::whereHas('slot', function ($query) use ($availableSlot) {
                  $query->where('slot_id', $availableSlot->id);
              })->whereHas('slot', function ($query) use ($parkinglot_id) {
                  $query->where('parkinglot_id', $parkinglot_id);
              })->latest()->first();
              @endphp
              @if ($ticket)
              <td>{{$ticket->date}}</td>
              <td>{{$ticket->check_in}}</td>
              @else
              <td>none</td>
              <td>none</td>
              @endif
            </tr>
            @endforeach
            
            
          </tfoot>
        </table>
      </div>
    </div>
    <div class="col-xl-6">
      <h5 class="mb-3 text-center text-black-50">Occupied Slots</h5>
      <div class="table mb-0">
        <table id="mapTable2"
          class="p-0 container text-center table table-bordered sm-responsive table-responsive table-hover bg-light">
          <thead>
            <tr>
              <th>Slot Number</th>
              <th>Slot Type</th>
              <th>Slot Hour Rate</th>
              <th><span class="nowrap">Check-In</span><br>Date</th>
              <th><span class="nowrap">Check-In</span><br>Time</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @foreach ($occupiedSlots as $occupiedSlot)
            <tr>
              <td>{{$occupiedSlot->number}}</td>
              <td>{{$occupiedSlot->type}}</td>
              <td>{{$occupiedSlot->rate}} $</td>
              @php
              $ticket = Ticket::whereHas('slot', function ($query) use ($occupiedSlot) {
                  $query->where('slot_id', $occupiedSlot->id);
              })->whereHas('slot', function ($query) use ($parkinglot_id) {
                  $query->where('parkinglot_id', $parkinglot_id);
              })->latest()->first();
              @endphp
              @if ($ticket)
              <td>{{$ticket->date}}</td>
              <td>{{$ticket->check_in}}</td>
              @else
              <td>none</td>
              <td>none</td>
              @endif
            </tr>
            @endforeach
            
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</main>
@endsection
