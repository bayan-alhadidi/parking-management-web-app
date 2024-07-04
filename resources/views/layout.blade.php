<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - Car Parking</title>
  <!-- Css Files -->
  <link rel="stylesheet" href="/css/all.min.css" />
  <link rel="stylesheet" href="/css/bootstrap.css">
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/parking.css" />
  <!-- Google Fonts (Montserrat)-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
  <!-- JavaScript Links-->
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark some-dark pe-xl-5 p-2 navbar-wrap">
    <!-- Sidebar Toggle-->
    <button class="fs-4 btn btn-link btn-sm order-l0 g-0 ms-lg-0 me-xl-0 burger-icon text-white" id="sidebarToggle"
      href="#!">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Logo-->
    <a class="navbar-brand ms-4 d-none d-sm-block" href="/" target="_blank"><img
        src="/assets/images/logo light.png" alt="Brand Logo" /></a>
    <h4 class="brand-name">ParkPro</h4>
    <!-- Navbar Profile-->
    @php
    $username = auth()->user()->name;
    @endphp
    <div class="me-2 py-2 text-white"> {{$username}}</div>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 mx-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle profile-image" id="navbarDropdown" href="#" role="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <img class="w-100 h-100" src="/assets/images/profile.jpg" alt="Profile Picture" />
        </a>
        <ul class="dropdown-menu dropdown-menu-end some-dark" aria-labelledby="navbarDropdown">
          <li>
            <a class="profile-item dropdown-item py-2 text-white" href="#!">Profile</a>
          </li>
          <li>
            <a class="profile-item dropdown-item py-2 text-white" href="#!">Activity Log</a>
          </li>
          <li>
            <hr class="dropdown-divider light" />
          </li>
          <li>
            <a class="profile-item dropdown-item py-2 text-white" href="#!">Help</a>
          </li>
          <li>
            <a class="profile-item dropdown-item py-2 text-white" href="/logout">Log out</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- Sidenav-->
  <div id="layoutSidenav">
    @yield('sidenav')
    <div id="layoutSidenav_content">
      <!-- Body -->
      @yield('body')
      <!-- Footer -->
      <footer class="py-3 some-dark mt-auto sticky">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-white">Copyright &copy; Parking-Pro 2023</div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- JavaScript Files-->
  
  <script src="/js/all.min.js"></script>
  <script src="/js/parking.js"></script>
  <script src="/js/charts.js"></script>
</body>
</html>