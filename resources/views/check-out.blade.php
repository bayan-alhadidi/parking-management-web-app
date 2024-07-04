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
  <form class="mx-md-3 text-center" method="POST" action="/check-out/filter">
    @csrf
    @if(Session::has('success'))
    <div class="alert alert-success">{{Session::get('success')}}</div>
    @endif
    @if(Session::has('fail'))
    <div class="alert alert-danger">{{Session::get('fail')}}</div>
    @endif
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" name="match" id="matchTag" value="{{old('match')}}">
          <option name="tag" value="id">Match by ticket ID</option>
          <option name="tag" value="number">Match by slot number</option>
          <option name="tag" value="license_plate">Match by vehicle plate</option>
          <option name="tag" value="name">Match by customer name</option>
        </select>
        <span class="text-danger">@error('match') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="matchTagInput" type="text" name="value" value="{{old('value')}}"/>
        <label name="tagPlaceHolder" class="ps-4 text-black-50" for="matchTagInput">Enter value to match by
          ticket ID</label>
          <span class="text-danger">@error('value') {{$message}} @enderror</span>
      </div>
      <button type="submit" class="btn btn-cta w-180px" value="search"><i class="fas fa-search"></i></button>
    </div>
    <hr class="w-75 m-auto my-3">
    <label class="mt-4 text-black-50" for="enterDate">Exiting Vehicle INFO</label>
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
          <th>Check Out</th>
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
          <td><a href="/edit-check-out/{{$checkedIn->id}}" class="btn btn-brown"><i class="fa fa-car"></i></a></td>
        </tr>
        @endforeach
        </tfoot>
      </table>
  </form>
</main>
@endsection