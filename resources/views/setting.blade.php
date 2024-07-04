@php 
use App\Models\Parkinglot;
@endphp
@extends('layout')
@section('title','Settings')
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
        <a class="nav-link" href="/map"><i class="fa-solid fa-suitcase"></i><span class="mx-2"></span>
          Parking Map</a>
        <a class="nav-link link-active pointer"><i class="fa-solid fa-gear"></i><span class="mx-2"></span>
          Parking
          Settings</a>
      </div>
    </div>
  </nav>
</div>
@endsection
@section('body')
<main class="shade flex-1 py-5 container-fluid wide setting">
  <h4 class="text-center text-black-50">Parking Settings</h4>
  <hr class="my-5 w-75 m-auto ">
  <h5 class="mt-5 text-center text-black-50">Modify Parking Lot</h5>
  <form class="mb-5 mx-md-3 text-center" method="POST" action="/set-parkinglot/{{$parkinglot_id}}">
    @csrf
    @method('PUT')
    @if(Session::has('parkinglotSuccess'))
    <div class="alert alert-success">{{Session::get('parkinglotSuccess')}}</div>
    @endif
    @if(Session::has('parkinglotFail'))
    <div class="alert alert-danger">{{Session::get('parkinglotFail')}}</div>
    @endif
    @php
    $parkinglot = Parkinglot::where('id', $parkinglot_id)->first();
    @endphp
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="parking_name" type="text" name="parking_name" value="{{$parkinglot->parking_name}}"/>
        <label class="ps-4 text-black-50" for="parking_name">Parking Lot Name</label>
        <span class="text-danger">@error('parking_name') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="address" type="text" name="address" value="{{$parkinglot->address}}"/>
        <label class="ps-4 text-black-50" for="address">Parking Lot Address</label>
        <span class="text-danger">@error('address') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="flex justify-content-center align-items-center">
      <input class="reversed m-1 w-120px" type="submit" value="Save">
    </div>
  </form>
  <form class="mb-5 mx-md-3 text-center" method="POST" action="/closeParkinglot/{{$parkinglot_id}}">
    @csrf
    @method('PUT')
    <div class="pt-3">
      To close your account click <input class="reversed m-1" type="submit" value="Close Parking Lot">
    </div>
  </form>
  <hr class="mt-4 mb-5 w-75 m-auto">
  <h5 class="mt-5 text-center text-black-50">Add/Delete Employee</h5>
  <form class="mx-md-3 text-center" method="POST" action="/add-employee">
    @csrf
    @if(Session::has('employeeSuccess'))
    <div class="alert alert-success">{{Session::get('employeeSuccess')}}</div>
    @endif
    @if(Session::has('employeeFail'))
    <div class="alert alert-danger">{{Session::get('employeeFail')}}</div>
    @endif
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="employeeName" type="text" name="name" value="{{old('name')}}"/>
        <label class="ps-4 text-black-50" for="employeeName">Employee Name</label>
        <span class="text-danger">@error('name') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="employeeEmail" type="email" name="email" value="{{old('email')}}"/>
        <label class="ps-4 text-black-50" for="employeeEmail">Employee Email</label>
        <span class="text-danger">@error('email') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="row justify-content-center w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="employeePassword" type="password" name="password" value="{{old('password')}}"/>
        <label class="ps-4 text-black-50" for="employeePassword">Employee Password</label>
        <span class="text-danger">@error('password') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="confirmEmployeePassword" type="password" name="confirm-password" value="{{old('confirm-password')}}"/>
        <label class="ps-4 text-black-50" for="confirmEmployeePassword">Confirm Employee Password</label>
        <span class="text-danger">@error('confirm-password') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" type="text" id="employeeRoleType">
          <option value="employee">Employee Role Type</option>
          <option value="Admin">Admin</option>
          <option value="employee">Employee</option>
        </select>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" type="text" name="shift" id="employeeWorkShif">
          <option value="morning">Employee Work Shift</option>
          <option value="admin">Admin</option>
          <option value="morning">Morning</option>
          <option value="evening">Evening</option>
          <option value="midnight">Midnight</option>
        </select>
        <span class="text-danger">@error('shift') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="flex justify-content-center align-items-center">
      <input class="reversed m-1 w-180px" type="submit" value="Add employee">
    </div>
  </form>
  <hr class="mt-4 mb-5 w-75 m-auto">
  <h5 class="text-center text-black-50">Employees Table</h5>
  <table id="settingsTable1"
    class="m-auto mt-4 text-center table table-bordered responsive table-responsive table-hover mb-0 bg-light">
    <thead>
      <tr>
        <th>Employee Name</th>
        <th>Employee Email</th>
        <th>Employee Role Type</th>
        <th>Employee Work Shift</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      @foreach ($users as $user)
      <tr>
        <td>{{$user['name']}}</td>
        <td>{{$user['email']}}</td>
        <td>{{$user->role->name}}</td>
        <td>{{$user->role->shift}}</td>
        <td>
          @if ($user->role->id != 1)
          <button class="btn btn-brown" onclick="confirmDelete({{$user->id}})">
            <i class="fa fa-trash"></i>
          </button>
          @endif
        </td>
      </tr>
      @endforeach
      
    </tfoot>
  </table>
  <hr class="my-5 w-75 m-auto ">
  <h5 class="mt-5 text-center text-black-50">Modify Slots</h5>
  <form class="mb-5 mx-md-3 text-center" method="POST" action="/add-slot">
    @csrf
    @if(Session::has('slotSuccess'))
    <div class="alert alert-success">{{Session::get('slotSuccess')}}</div>
    @endif
    @if(Session::has('slotFail'))
    <div class="alert alert-danger">{{Session::get('slotFail')}}</div>
    @endif
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="slotNumber" type="text" name="number" value="{{old('number')}}" />
        <label class="ps-4 text-black-50" for="slotNumber">Slot Number</label>
        <span class="text-danger">@error('number') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" type="text" name="type" id="slotType">
          <option value="car">Slot Type</option>
          <option value="car">Car</option>
          <option value="van">Van</option>
          <option value="motorbike">Motorbike</option>
        </select>
        <span class="text-danger">@error('type') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="row justify-content-center pb-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="slotHourRate" type="text"  name="rate" value="{{old('rate')}}"/>
        <label class="ps-4 text-black-50" for="slotHourRate">Slot Hour Rate</label>
        <span class="text-danger">@error('rate') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="flex justify-content-center align-items-center">
      <input class="reversed m-1 w-180px" type="submit" value="Add slot">
    </div>
  </form>
  <h5 class="mb-4 text-center text-black-50">Slots And Rates </h5>
  <table id="settingsTable2"
    class="px-md-5 container text-center table table-bordered sm-responsive table-responsive table-hover bg-light">
    <thead>
      <tr>
        <th>Slot Number</th>
        <th>Slot Type</th>
        <th>Slot Hour Rate</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      @foreach ($slots as $slot)
      <tr>
        <td>{{$slot['number']}}</td>
        <td>{{$slot['type']}}</td>
        <td>{{$slot['rate']}} $</td>
        <td>
          <a href="/edit-slot/{{$slot->id}}" class="btn btn-brown"><i class="fa fa-pencil"></i></a>
          <button class="btn btn-brown" onclick="confirmDeleteSlot({{$slot->id}})">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
      @endforeach

    </tfoot>
  </table>
</main>
@endsection