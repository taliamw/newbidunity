<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BidUnity Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/assets_admin/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/assets_admin/images/favicon.png') }}" />
</head>
<body>
<div class="container-scroller">
<div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0">
          <div class="card-body card-body-padding d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center justify-content-between">
              <a href="https://www.bootstrapdash.com/product/corona-free/"><i class="mdi mdi-home me-3 text-white"></i></a>
              <button id="bannerClose" class="btn border-0 p-0">
                <i class="mdi mdi-close text-white me-0"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- partial:partials/_sidebar.html -->


      <!--logo-->
<br><br>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a href="home" class="logo d-flex align-items-center me-auto me-lg-0">
            <div class="logo d-flex align-items-center me-auto me-lg-0">
                <img src="assets/img/logo.png" alt="">
                <h1 style="color: red;">BidUnity<span>.</span></h1>
            </div>
    </div>

<!--sidebar-->
    <ul class="nav">

      <li class="nav-item nav-category">
        <span class="nav-link">Navigation</span>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="index.html">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="pages/tables/basic-table.html">
          <span class="menu-icon">
            <i class="mdi mdi-table-large"></i>
          </span>
          <span class="menu-title">Tables</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="/chartjs-page">
          <span class="menu-icon">
            <i class="mdi mdi-chart-bar"></i>
          </span>
          <span class="menu-title">Charts</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="/add_admin">
          <span class="menu-icon">
            <i class="mdi mdi-chart-bar"></i>
          </span>
          <span class="menu-title">Create Admin</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="/viewusers">
          <span class="menu-icon">
            <i class="mdi mdi-chart-bar"></i>
          </span>
          <span class="menu-title">ViewUsers</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="/admin/listings">
          <span class="menu-icon">
            <i class="mdi mdi-chart-bar"></i>
          </span>
          <span class="menu-title">Publish listing</span>
        </a>
      </li>
      <li class="nav-item menu-items">
        <a class="nav-link" href="/reports/user-report">
          <span class="menu-icon">
            <i class="mdi mdi-file-document-box"></i>
          </span>
          <span class="menu-title">Reports</span>
        </a>
      </li>
    </ul>
  </nav>
   <!--end of side bar nav-->

   <!-- partial -->
  <div class="container-fluid page-body-wrapper">



<!-- partial:partials/_navbar.html -->
<nav class="navbar p-0 fixed-top d-flex flex-row">
  <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
    <a class="navbar-brand brand-logo-mini" href="/dashboard"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav w-100">
      <li class="nav-item w-100">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
          <input type="text" class="form-control" placeholder="Search products">
        </form>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">

      <li class="nav-item nav-settings d-none d-lg-block">
        <a class="nav-link" href="#">
          <i class="mdi mdi-view-grid"></i>
        </a>
      </li>
      <li class="nav-item dropdown border-left">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="mdi mdi-email"></i>
          <span class="count bg-success"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <h6 class="p-3 mb-0">Messages</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
              <p class="text-muted mb-0"> 1 Minutes ago </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
              <p class="text-muted mb-0"> 15 Minutes ago </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
            </div>
            <div class="preview-item-content">
              <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
              <p class="text-muted mb-0"> 18 Minutes ago </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <p class="p-3 mb-0 text-center">4 new messages</p>
        </div>
      </li>
      <li class="nav-item dropdown border-left">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
          <i class="mdi mdi-bell"></i>
          <span class="count bg-danger"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
          <h6 class="p-3 mb-0">Notifications</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-calendar text-success"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Event today</p>
              <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-settings text-danger"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Settings</p>
              <p class="text-muted ellipsis mb-0"> Update dashboard </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-dark rounded-circle">
                <i class="mdi mdi-link-variant text-warning"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <p class="preview-subject mb-1">Launch Admin</p>
              <p class="text-muted ellipsis mb-0"> New admin wow! </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <p class="p-3 mb-0 text-center">See all notifications</p>
        </div>
      </li>

  </div>
</nav>

    <!-- ... your HTML structure ... -->
    @yield('content')
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
        </div>
    </footer>
    <!-- partial -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ asset('assets/assets_admin/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('assets/assets_admin/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/assets_admin/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ asset('assets/assets_admin/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('assets/assets_admin/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/assets_admin/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/jquery.cookie.js') }}" type="text/javascript"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('assets/assets_admin/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/misc.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/settings.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/todolist.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/assets_admin/js/dashboard.js') }}"></script>
<!-- End custom js for this page -->
@yield('scripts')
</body>
</html>
