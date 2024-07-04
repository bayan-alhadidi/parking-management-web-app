<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HomePage - Car Parking</title>
  <!-- Css Files -->
  <link rel="stylesheet" href="./css/all.min.css" />
  <link rel="stylesheet" href="./css/bootstrap.css">
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/parking.css" />
  <!-- Google Fonts (Montserrat)-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet" />
  <!-- JavaScript Links-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed sb-sidenav-toggled">
  <nav class="sb-topnav navbar navbar-expand navbar-dark some-dark pe-xl-5 p-2 navbar-wrap navbar-shadow">
    <!-- Sidebar Toggle-->
    <button class="fs-4 btn btn-link btn-sm g-0 ms-lg-0 me-xl-0 burger-icon text-white" id="sidebarToggle" href="#!">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Logo-->
    <a class="navbar-brand ms-4 d-none d-sm-block" href="/"><img src="./assets/images/logo light.png"
        alt="Brand Logo" /></a>
    <h4 class="brand-name">ParkPro</h4>
    <!-- Log In/SignUp Button-->
    <a>
      <button id="primary" type="button" class="btn btn-cta">Log In</button>
    </a>
    <a>
      <button id="secondery" type="button" class="btn secondery">Sign Up</button>
    </a>
  </nav>
  <!-- Sidenav-->
  <div id="layoutSidenav" class="flex-column">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu brown pt-5">
          <div class="nav pt-3 link-wrapper">
            <a class="nav-link no-hover"><i class="fas fa-tachometer-alt"></i><span class="mx-2"></span>
              Dashboard</a>
            <a class="nav-link no-hover"><i class="fas fa-book-open"></i><span class="mx-2"></span> History</a>
            <hr class="custom-divider my-4" />
            <p class="text-white-50 ms-3">Tickets</p>
            <a class="nav-link no-hover"><i class="fa-solid fa-ticket"></i>
              <span class="mx-2 no-hover"></span> Check In</a>
            <a class="nav-link no-hover"><i class="fa-regular fa-credit-card"></i><span class="mx-2"></span>
              Check Out</a>
            <hr class="custom-divider my-4" />
            <a class="nav-link no-hover"><i class="fa-solid fa-suitcase"></i><span class="mx-2"></span>
              Parking Map</a>
            <a class="nav-link no-hover"><i class="fa-solid fa-gear"></i><span class="mx-2"></span> Parking
              Settings</a>
          </div>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content" style="min-height:calc(100vh - 56px)">
      <!-- Body -->
      <!-- Video Carousel -->
      <div class="hero-section flex-1 light">
        <div class="carousel-container">
          <div class="carousel-slide active">
            <video width="100%" height="100%" autoplay loop muted>
              <source src="assets/videos/long_1.mp4" type="video/mp4">
            </video>
          </div>
          <div class="carousel-slide">
            <video width="100%" height="100%" autoplay loop muted>
              <source src="assets/videos/long_2.mp4" type="video/mp4">
            </video>
          </div>
          <div class="carousel-slide">
            <video width="100%" height="100%" autoplay loop muted>
              <source src="assets/videos/Long_3.mp4" type="video/mp4">
            </video>
          </div>
        </div>
        <div class="overlay" id="overlay"></div>
        <!-- Hero Content-->
        <div class="hero-content col-10 col-xl-8">
          <h1 id="hero-title">“ParkPro: Where organization meets innovation. Take control of your parking lot with
            us.”
          </h1>
          <p id="hero-discription">Say goodbye to parking lot chaos with ParkPro! Our online car parking management
            system
            makes it easy for
            parking lot managers to keep track of available spots, reservations, and payments in real-time. With
            user-friendly features and secure payment options, ParkPro takes the stress out of managing your parking
            lot. Try it out today and experience the convenience of streamlined parking lot management!</p>
          <button id="hero-button" class="btn btn-cta">Learn More About Us</button>
        </div>
        <!-- Login Form -->
        <div
          class="login-form px-0 card shadow-lg border-0 rounded-lg absolute center background-25 col-10 col-lg-8 col-xl-6">
          <div class="card-header text-white  border-white background-50">
            <h3 class="text-center font-weight-light my-2 fs-4">
              Login
            </h3>
          </div>
          <div class="card-body pt-4">
            <form class="text-center" method="POST" action="/login">
              @csrf
              @if(Session::has('loginSuccess'))
              <div class="alert alert-success">{{Session::get('loginSuccess')}}</div>
              @endif
              @if(Session::has('loginFail'))
              <div class="alert alert-danger">{{Session::get('loginFail')}}</div>
              @endif
              <div class="form-floating mb-3">
                <input class="form-control needChecking" id="loginInputEmail" type="email" name="login_email" value="{{old('login_email')}}"
                  placeholder="name@example.com" />
                <label for="inputEmail">Email address</label>
                <span class="text-danger">@error('login_email') {{$message}} @enderror</span>
              </div>
              <div class="form-floating mb-3">
                <input class="form-control needChecking" id="loginInputPassword" type="password" name="login_password" value="{{old('login_password')}}"
                  placeholder="Password" />
                <label for="inputPassword">Password <small><small>(from 8 to 15
                      characters)</small></small></label>
                <span class="text-danger">@error('login_password') {{$message}} @enderror</span>
              </div>
              <div id="hideShowIcons">
                <i class="fa-regular fa-eye-slash" id="hideIcon"></i>
                <i class="fa-regular fa-eye" id="showIcon"></i>
              </div>
              <input class="mt-4 btn btn-cta w-50" type="submit" value="Login">
            </form>
          </div>
          <div class="card-footer text-center py-3 border-white">
            <div class="small">
              <a class="go-to-signup hyper-link">Need an account? Sign up!</a>
            </div>
          </div>
          <div class="close">X</div>
        </div>
        <!-- Sign up Form -->
        <div class="signup-form px-0 card shadow-lg border-0 rounded-lg absolute center background-25 col-11 col-xl-8">
          <div class="card-header text-white  border-white background-50">
            <h3 class="text-center font-weight-light my-2 fs-4">
              Create Account
            </h3>
          </div>
          <div class="card-body pt-4">
            <form class="text-center" method="POST" action="/register">
              @csrf
              @if(Session::has('registerSuccess'))
              <div class="alert alert-success">{{Session::get('registerSuccess')}}</div>
              @endif
              @if(Session::has('registerFail'))
              <div class="alert alert-success">{{Session::get('registerFail')}}</div>
              @endif
              <div class="row justify-content-center mb-3">
                <div class="col-12 col-md-6">
                  <div class="form-floating mb-0">
                    <input class="form-control needChecking" id="inputName" type="text" name="name" value="{{old('name')}}"
                      placeholder="Enter your full name" />
                    <label for="inputName">Full name <small><small>(First Last) &ltonly one space
                          allowed&gt</small></small></label>
                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                  </div>
                </div>
              </div>
              <div class="form-floating mb-3">
                <input class="form-control needChecking" id="signupInputEmail" type="email" name="email" value="{{old('email')}}"
                  placeholder="name@example.com" />
                <label for="inputEmail">Email address</label>
                <span class="text-danger">@error('email') {{$message}} @enderror</span>
              </div>
              <div class="row mb-3">
                <div class="col-12 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control needChecking" id="signupInputPassword" type="password" name="password" value="{{old('password')}}"
                      placeholder="Create a password" />
                    <label for="inputPassword">Password <small><small>(from 8 to 15
                          characters)</small></small></label>
                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-floating mb-3">
                    <input class="form-control needChecking" id="inputPasswordConfirm" type="password" name="confirm-password" value="{{old('confirm-password')}}"
                      placeholder="Confirm password" />
                    <label for="inputPasswordConfirm">Confirm Password</label>
                    <span class="text-danger">@error('confirm-password') {{$message}} @enderror</span>
                  </div>
                  <div id="hideShowIcons">
                    <i class="fa-regular fa-eye-slash" id="hideIconConfirm"></i>
                    <i class="fa-regular fa-eye" id="showIconConfirm"></i>
                  </div>
                </div>
              </div>
              <input class="mt-4 btn btn-cta w-50" type="submit" value="Create Account">
            </form>
          </div>
          <div class="card-footer text-center py-3 border-white">
            <div class="small">
              <a class="hyper-link go-to-login">Have an account? Go to login</a>
            </div>
          </div>
          <div class="close">X</div>
        </div>
      </div>
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
  <script src="./js/parking.js"></script>
  <script src="./js/login-signup.js"></script>
</body>

</html>