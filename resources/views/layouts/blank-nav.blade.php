
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    @yield('extra-css')
</head>
<body class="sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          株式会社ABC
          {{-- {{$user->name}} --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="{{asset('img/user-icon.png')}}"
                     alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">
                Jeferson Bonayon
                {{-- {{$user->name}} --}}
              </h3>

              <p class="text-muted text-center">
                Software Engineer
                {{-- {{$user->company}} --}}
              </p>

              <ul class="list-group list-group-unbordered mb-3">

              </ul>

              <a href="various-settings" class="btn btn-primary btn-block"><b>Profile</b></a>

              <a href="#" class="btn btn-danger btn-block"><b>Logout</b></a>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="client-home" class="brand-link">
      <img src="{{asset('img/w-logo-green.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <p class="brand-text font-weight-light">Waiton</p>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/user-icon.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="various-settings" class="d-block">株式会社ABC</a>
        </div>
      </div>

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <main class="py-4">
            @yield('content')
        </main>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

@yield('extra-scripts')

</body>
</html>
