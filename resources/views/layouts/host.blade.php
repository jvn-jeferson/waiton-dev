
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{config('app.name')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition sidebar-mini dark-mode">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" href="#" role="button">
          <i class="fas fa-envelope"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#" role="button">
          <i class="fas fa-bell"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        株式会社ABC
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
      <img src="{{asset('img/w-logo-green.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Waiton</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/user-icon.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">株式会社ABC</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="home" class="nav-link  @if(request()->route()->getName() == 'home') active  @endif">
              <i class="nav-icon fas fa-home"></i>
              <p>
              ホーム
              </p>
            </a>
          </li>

          <li class="nav-header mt-3">顧客管理</li>

          <li class="nav-item">
            <a href="customer-selection" class="nav-link @if(request()->route()->getName() == 'customer-selection') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
              顧客の選択
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="message-clients" class="nav-link @if(request()->route()->getName() == 'message-clients') active @endif">
              <i class="nav-icon fas fa-paper-plane"></i>
              <p>
                全顧客への連絡
              </p>
            </a>
          </li>

          <li class="nav-item"> 
            <a href="client-list" class="nav-link  @if(request()->route()->getName() == 'client-list') active @endif">
              <i class="nav-icon fas fa-address-book"></i>
              <p>
                顧客の一覧
              </p>
            </a>
          </li>
          
          <li class="nav-header mt-3">アカウントツール</li>
          <li class="nav-item">
            <a href="account-management" class="nav-link @if(request()->route()->getName() == 'account-management') active  @endif">
              <i class="nav-icon fa fa-cog"></i>
              <p>
                事務所内の管理
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="plan-update" class="nav-link @if(request()->route()->getName() == 'plan-update') active  @endif">
                <i class="nav-icon fas fa-calendar"></i>
                <p>
                  プラン確認・変更
                </p>
              </a>
          </li>

          <li class="nav-header mt-3">
            エクストラ
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bookmark"></i>
                <p>
                  税理士業務簿
                </p>
              </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon far fa-question-circle"></i>
              <p>
                FAQ
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link">
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
