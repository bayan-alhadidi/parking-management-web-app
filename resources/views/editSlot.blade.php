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
        <a class="nav-link" href="/setting"><i class="fa-solid fa-gear"></i><span class="mx-2"></span>
          Parking
          Settings</a>
      </div>
    </div>
  </nav>
</div>
@endsection
@section('body')
<main class="shade flex-1 py-5 container-fluid wide setting">
  <hr class="my-5 w-75 m-auto ">
  <h5 class="mt-5 text-center text-black-50">Edit Slots</h5>
  <form class="mb-5 mx-md-3 text-center" method="POST">
    @csrf
    @if(Session::has('slotSuccess'))
    <div class="alert alert-success">{{Session::get('slotSuccess')}}</div>
    @endif
    @if(Session::has('slotFail'))
    <div class="alert alert-danger">{{Session::get('slotFail')}}</div>
    @endif
    <div class="row justify-content-center py-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="slotNumber" type="text" name="number" value="{{$slot->number}}" />
        <label class="ps-4 text-black-50" for="slotNumber">Slot Number</label>
        <span class="text-danger">@error('number') {{$message}} @enderror</span>
      </div>
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <select class="select-style" type="text" name="type" id="slotType">
          <option value="{{$slot->type}}">{{$slot->type}}</option>
          <option value="car">Car</option>
          <option value="van">Van</option>
          <option value="motorbike">Motorbike</option>
        </select>
        <span class="text-danger">@error('type') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="row justify-content-center pb-3 w-100 m-auto">
      <div class=" form-floating mb-3 col-12 col-sm-6 col-lg-6">
        <input class="form-control needChecking" id="slotHourRate" type="text"  name="rate" value="{{$slot->rate}}"/>
        <label class="ps-4 text-black-50" for="slotHourRate">Slot Hour Rate</label>
        <span class="text-danger">@error('rate') {{$message}} @enderror</span>
      </div>
    </div>
    <div class="flex justify-content-center align-items-center">
      @method('PUT')
      <input class="reversed m-1 w-180px" type="submit" value="Confirm" formaction="/edit-slot/{{$slot->id}}">
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
        <th>Edit</th>
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
        </td>
      </tr> 
      @endforeach

    </tfoot>
  </table>
</main>
@endsection