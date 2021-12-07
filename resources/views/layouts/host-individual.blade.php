
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
<body class="hold-transition sidebar-mini">
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
          {{Auth::user()->accountingOffice->name}}
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
                {{Auth::user()->accountingOfficeStaff->name}}
              </h3>

              <p class="text-muted text-center">
                @if(Auth::user()->role_id == 2)
                  Manager
                @else
                  Staff
                @endif
              </p>

              <ul class="list-group list-group-unbordered mb-3">
                
              </ul>

              <a href="various-settings" class="btn btn-primary btn-block"><b>Client Profile</b></a>
              
              <a href="{{route('home')}}" class="btn btn-danger btn-block"><b>Back to Home</b></a>
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
    <a href="{{route('access-dashboard', ['client_id' => $hashids->encode($client->id)])}}" class="brand-link">
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
          <a href="various-settings" class="d-block">{{$client->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('access-dashboard', ['client_id' => $hashids->encode($client->id)])}}" class="nav-link  @if(request()->route()->getName() == 'access-dashboard') active  @endif">
              <i class="nav-icon fas fa-home"></i>
              <p>
              ホーム
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('access-contact', ['client_id' => $hashids->encode($client->id)])}}" class="nav-link  @if(request()->route()->getName() == 'access-contact') active  @endif">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                メッセージを送る
              </p>
            </a>
          </li>
          
          <li class="nav-header mt-3">文書</li>
          <li class="nav-item">
            <a href="{{route('access-inbox', ['client_id' => $hashids->encode($client->id)])}}" class="nav-link @if(request()->route()->getName() == 'access-inbox') active  @endif">
              <i class="nav-icon fas fa-upload"></i>
              <p>
              To　会計事務所
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('access-outbox', ['client_id' => $hashids->encode($client->id)])}}" class="nav-link @if(request()->route()->getName() == 'access-outbox') active  @endif">
              <i class="nav-icon fas fa-download"></i>
              <p>
              From　会計事務所
              </p>
            </a>
          </li>
          
          <li class="nav-header mt-3">記録</li>
          <li class="nav-item">
            <a href="{{route('access-taxation-history', ['client_id' => $hashids->encode($client->id)])}}" class="nav-link @if(request()->route()->getName() == 'access-taxation-history')  active  @endif">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                過去の決算
                </p>
              </a>
          </li>
          <li class="nav-item">
            <a href="notification-history" class="nav-link @if(request()->route()->getName() == 'notification-history') active  @endif">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                通知
                  
                </p>
              </a>
          </li>

          
          <li class="nav-header mt-3">ツール</li>
          <li class="nav-item">
            <a href="various-settings" class="nav-link @if(request()->route()->getName() == 'various-settings') active  @endif">
                <i class="nav-icon fas fa-cogs"></i>
                <p>
                各種設定
                </p>
              </a>
          </li>
          
          <li class="nav-header mt-5"></li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
              <i class="nav-icon far fa-question-circle"></i>
              <p>
                FAQ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="../gallery.html" class="nav-link">
              <i class="nav-icon far fa-comment-dots"></i>
              <p>
              問合せ
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
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
