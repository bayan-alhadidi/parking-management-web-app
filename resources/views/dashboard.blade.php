@php
use App\Models\Slot;
use Carbon\Carbon;
@endphp
@extends('layout')
@section('title', 'Dashboard')
@section('sidenav')
<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu brown pt-5">
      <div class="nav pt-3 link-wrapper">
        <a class="nav-link link-active pointer"><i class="fas fa-tachometer-alt"></i><span class="mx-2"></span>
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
@php $currentTime = Carbon::now() @endphp
<main class="shade flex-1 py-5 text-black-50 dashboard ">
  <h4 class="mb-5 text-center text-black-50">Dashboard</h4>
  <!-- Parking Lot Statistics -->
  <div class="row justify-content-center container-fluid wide mx-auto mt-0">
    <h5 class="mb-3">Lot Current Statistics</h5>
    <div class="row mx-0">
      <div class="col-12">
        <div class="col-12 col-md-9 col-lg-6 px-0">
          <div class="info-box shade mb-0">
            <span style="width:64px" class="info-box-icon bg-warning text-white"><i class="far fa-flag"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-bold">Slots Total Number</span>
              @php
              $slotsCount = Slot::where('parkinglot_id', $parkinglot_id)->count();
              @endphp
              <span class="info-box-number">{{$slotsCount}}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 px-0">
        <div class="mx-2 mt-4 px-1">
          <div class="info-box mb-0 text-bg-danger">
            <span class="info-box-icon"><i class="fa-solid fa-store-slash" style="color: #ffffff;"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Occupied</span>
              @php
                $occupiedCount = Slot::where('status', 'occupied')->where('parkinglot_id', $parkinglot_id)->count();
                if($slotsCount != 0){ $occupiedPercent = ($occupiedCount/$slotsCount)* 100; }else {
                  $occupiedPercent = 0;
                }
                $formatted_result = number_format($occupiedPercent, 2);
              @endphp
              <span class="info-box-number">{{$occupiedCount}}</span>
              <div class="progress">
                <div class="progress-bar" style="width: {{$occupiedPercent}}%"></div>
              </div>
              <span class="progress-description">{{$formatted_result}}%</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-lg-4 px-0">
        <div class="mx-2 mt-4 px-1">
          <div class="info-box mb-0 text-bg-success">
            <span class="info-box-icon"><i class="fa-solid fa-book" style="color: #ffffff;"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Available</span>
              @php
                $availableCount = Slot::where('status', 'available')->where('parkinglot_id', $parkinglot_id)->count();
                if($slotsCount != 0){ $availablePercent = ($availableCount/$slotsCount)* 100; }else {
                  $availablePercent = 0;
                }
                $formatted_result = number_format($availablePercent, 2);
              @endphp
              <span class="info-box-number">{{$availableCount}}</span>
              <div class="progress">
                <div class="progress-bar" style="width: {{$availablePercent}}%"></div>
              </div>
              <span class="progress-description">{{$formatted_result}}%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="mt-4">
  <!-- Sub History -->
  <div class="row justify-content-center container-fluid wide mx-auto mt-5">
    <h5 class="mb-3">Last 24 Hour History</h5>
    <div class="mx-2 px-4">
      <div class="table mb-0">
        <table id="subHistoryTable"
          class="text-center table table-bordered table-responsive table-hover mb-0  bg-light">
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
            
            @foreach ($last24tickets as $lastTicket)
            <tr>
              <td>{{$lastTicket->id}}</td>
              <td>{{$lastTicket->slot->number}}</td>
              <td>{{$lastTicket->vehicle->type}}</td>
              <td>{{$lastTicket->vehicle->license_plate}}</td>
              <td>{{$lastTicket->customer->name}}</td>
              <td>{{$lastTicket->date}}</td>
              <td>{{$lastTicket->check_in}}</td>
              <td>{{$lastTicket->check_out}}</td>
              @php
              $check_out = Carbon::parse($lastTicket->check_out);
              $check_in = Carbon::parse($lastTicket->check_in);
              // Calculate the rate for the ticket based on the slot's rate and duration
              $durationHours = $check_out->diffInHours($check_in);
              $ticketRate = $lastTicket->slot->rate * $durationHours;
              @endphp
              <td>{{$durationHours}}</td>
              <td>{{$ticketRate}} $</td>
              <td>{{$lastTicket->payment_status}}</td>
              <td>{{$lastTicket->payment_method}}</td>
            </tr>
            @endforeach
            
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <hr class="mt-4">
  <!-- Outcome Distribution -->
  <div class="row justify-content-center container-fluid wide mx-auto mt-5">
    <h5 class="mb-3">Outcome Chart</h5>
    <div class="mx-2 px-4">
      <div class="row align-items-end ms-0 pe-2">
        <p class="w-auto">Show chart for the passed...</p>
        <select class="col-12 col-sm-6 select-style text-black-75" name="time-span" id="time-span">
          <option value="">Select Time</option>
          <option value="Day">Day</option>
          <option value="Week">Week</option>
          <option value="Month">Month</option>
          <option value="Year">Year</option>
        </select>
      </div>
      <div class="card mb-0">
        <div class="card-header">
          <svg class="svg-inline--fa fa-chart-area me-1" aria-hidden="true" focusable="false" data-prefix="fas"
            data-icon="chart-area" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
            data-fa-i2svg="">
            <path fill="currentColor"
              d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64V400c0 44.2 35.8 80 80 80H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H80c-8.8 0-16-7.2-16-16V64zm96 288H448c17.7 0 32-14.3 32-32V251.8c0-7.6-2.7-15-7.7-20.8l-65.8-76.8c-12.1-14.2-33.7-15-46.9-1.8l-21 21c-10 10-26.4 9.2-35.4-1.6l-39.2-47c-12.6-15.1-35.7-15.4-48.7-.6L135.9 215c-5.1 5.8-7.9 13.3-7.9 21.1v84c0 17.7 14.3 32 32 32z">
            </path>
          </svg>
          The Span Of Time
        </div>
        <div class="card-body">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
          </div><canvas id="myAreaChart" width="1005" height="301"
            style="display: block; height: 241px; width: 804px;" class="chartjs-render-monitor"></canvas>
        </div>
        <div class="card-footer small text-muted">Updated at {{$currentTime}}</div>
      </div>
    </div>
  </div>
  <hr class="mt-3">
  <!-- Durations & Payments Statistics -->
  <div class="row justify-content-center container-fluid wide mx-auto mt-5">
    <h5 class="mb-3">Durations & Payments</h5>
    <div class="row justify-content-center col-12">
      <div class="col-12 col-md-9 col-lg-6 my-2">
        <div class="card h-100">
          <div class="card-header">
            <svg class="svg-inline--fa fa-chart-bar me-1" aria-hidden="true" focusable="false" data-prefix="fas"
              data-icon="chart-bar" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
              data-fa-i2svg="">
              <path fill="currentColor"
                d="M32 32c17.7 0 32 14.3 32 32V400c0 8.8 7.2 16 16 16H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H80c-44.2 0-80-35.8-80-80V64C0 46.3 14.3 32 32 32zm96 96c0-17.7 14.3-32 32-32l192 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-192 0c-17.7 0-32-14.3-32-32zm32 64H288c17.7 0 32 14.3 32 32s-14.3 32-32 32H160c-17.7 0-32-14.3-32-32s14.3-32 32-32zm0 96H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H160c-17.7 0-32-14.3-32-32s14.3-32 32-32z">
              </path>
            </svg>
            Durations
          </div>
          <div class="card-body">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div><canvas id="myBarChart" width="470" height="235"
              style="display: block; height: 188px; width: 376px;" class="chartjs-render-monitor"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated at {{$currentTime}}</div>
        </div>
      </div>
      <div class="col-12 col-md-9 col-lg-6 my-2">
        <div class="card h-100">
          <div class="card-header">
            <svg class="svg-inline--fa fa-chart-pie me-1" aria-hidden="true" focusable="false" data-prefix="fas"
              data-icon="chart-pie" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
              data-fa-i2svg="">
              <path fill="currentColor"
                d="M302 240V16.6c0-9 7-16.6 16-16.6C441.7 0 542 100.3 542 224c0 9-7.6 16-16.6 16H302zM30 272C30 150.7 120.1 50.3 237 34.3c9.2-1.3 17 6.1 17 15.4V288L410.5 444.5c6.7 6.7 6.2 17.7-1.5 23.1C369.8 495.6 321.8 512 270 512C137.5 512 30 404.6 30 272zm526.4 16c9.3 0 16.6 7.8 15.4 17c-7.7 55.9-34.6 105.6-73.9 142.3c-6 5.6-15.4 5.2-21.2-.7L318 288H556.4z">
              </path>
            </svg>
            Payments Method
          </div>
          <div class="card-body">
            <div class="chartjs-size-monitor">
              <div class="chartjs-size-monitor-expand">
                <div class=""></div>
              </div>
              <div class="chartjs-size-monitor-shrink">
                <div class=""></div>
              </div>
            </div><canvas id="myPieChart" width="498" height="248"
              style="display: block; height: 199px; width: 399px;" class="chartjs-render-monitor"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated at {{$currentTime}}</div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
<script>
  var monthlyTotals = @json($monthlyTotals);
  var dailyTotalsForMonth = @json($dailyTotalsForMonth);
  var dailyTotalsForWeek = @json($dailyTotalsForWeek);
  var hourlyTotals = @json($hourlyTotals);
  var paymentMethodCounts = @json($paymentMethodCounts);
  var averageDurations = @json($averageDurations);
</script>