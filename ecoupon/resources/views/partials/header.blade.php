<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
   <link rel="stylesheet" href="{{asset('css/style.css')}}">

    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- SEARCH FORM -->


    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <img src="{{asset('images/coupon_logo.png')}}" alt="ecoupon Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">eCoupon</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <div class="info">
          <a href="#" style="text-align: center;font-weight: bold; font-size:22px;
    text-transform: capitalize;color: #3389c8;" class="d-block font-weigth-bold">{{Auth::user()->fname}}</a> <br/>

             <a class="btn btn-link font-weight-bold text-decoration-none" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <i class="fa fa-power-off" style="color:red;" aria-hidden="true">  Logout</i>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                    </form>
             </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--<div class="form-inline">-->
      <!--  <div class="input-group" data-widget="sidebar-search">-->
      <!--    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">-->
      <!--    <div class="input-group-append">-->
      <!--      <button class="btn btn-sidebar">-->
      <!--        <i class="fas fa-search fa-fw"></i>-->
      <!--      </button>-->
      <!--    </div>-->
      <!--  </div>-->
      <!--</div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'home')  active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard

              </p>
            </a>
          </li>
               <li class="nav-item">
            <a href="{{route('appInfo')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'appinfo')  active @endif">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>
                App Info

              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="#" class="nav-link  @if(strtolower(Request::segment(1)) == 'coupon')  active @endif ">
              <i class="nav-icon fas fa-th"></i>
              <p>
                COUPON
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
                <a href="{{route('importCoupon')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Import Coupon</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('showCoupon')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Coupon List</p>
                </a>
              </li>

            </ul>
          </li>
         <li class="nav-item">
            <a href="{{route('withdrawl')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'withdrawl')  active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Withdraw List

              </p>
            </a>

          </li>
          <li class="nav-item">
            <a href="{{route('marketing')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'marketing')  active @endif">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                MARKETING

              </p>
            </a>

          </li>

          <li class="nav-item">
            <a href="{{route('customers')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'customers')  active @endif">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                CUSTOMERS

              </p>
            </a>

          </li>
		  <li class="nav-item">
            <a href="{{route('location')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'location')  active @endif">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                LOCATION / AREA

              </p>
            </a>

          </li>
           <li class="nav-item">
            <a href="{{route('storeName')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'store-name')  active @endif">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Store Name

              </p>
            </a>

          </li>


          <!--<li class="nav-item">-->
          <!--  <a href="location.html" class="nav-link">-->
          <!--    <i class="nav-icon fas fa-table"></i>-->
          <!--    <p>-->
          <!--      LOCATION-->

          <!--    </p>-->
          <!--  </a>-->

          <!--</li>-->


          <li class="nav-item">
            <a href="{{route('users')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'users')  active @endif">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                USERS

              </p>
            </a>

          </li>

             <li class="nav-item">
            <a href="{{route('pages')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'pages')  active @endif">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                ADD PAGES

              </p>
            </a>

          </li>

          <li class="nav-item">
            <a href="{{route('settings')}}" class="nav-link  @if(strtolower(Request::segment(1)) == 'settings')  active @endif">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                SETTINGS

              </p>
            </a>

          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
