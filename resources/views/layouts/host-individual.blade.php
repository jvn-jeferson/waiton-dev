<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="{{ asset('toppage_data/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('toppage_data/apple-touch-icon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WV7L6QS');
    </script>
    @yield('extra-css')
</head>

<body class="hold-transition sidebar-mini">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WV7L6QS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ Auth::user()->accountingOfficeStaff->accountingOffice->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('img/user-icon.png') }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">
                                    {{ Auth::user()->accountingOfficeStaff->name }}
                                </h3>

                                <p class="text-muted text-center">
                                    @if (Auth::user()->role_id == 2)
                                        Manager
                                    @else
                                        Staff
                                    @endif
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">

                                </ul>

                                <a href="{{ route('view-registration-information', ['client_id' => $hashids->encode($client->id)]) }}"
                                    class="btn btn-primary btn-block"><b>Client Profile</b></a>

                                <a href="{{ route('home') }}" class="btn btn-danger btn-block"><b>Back to Home</b></a>
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
            <a href="{{route('home') }}" class="brand-link logo-switch text-center">
                <img src="{{ asset('img/upfiling_logo_xl.png') }}" alt="UPF Logo"
                    class="brand-image-xs logo-xl my-auto mx-auto" > <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
                <img src="{{ asset('img/upfiling_logo_xs.png') }}" alt="UPF Logo"
                    class="brand-image-xl logo-xs my-auto mx-auto" >
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/user-icon.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('view-registration-information', ['client_id' => $hashids->encode($client->id)]) }}"
                            class="d-block">{{ $client->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('access-dashboard', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link  @if (request()->route()->getName() == 'access-dashboard') active @endif">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    ?????????
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('access-contact', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link  @if (request()->route()->getName() == 'access-contact') active @endif">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    ????????????????????????
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3">??????</li>
                        <li class="nav-item">
                            <a href="{{ route('access-inbox', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'access-inbox') active @endif">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>
                                    To??????????????????
                                    @if ($unviewed > 0)
                                        <span class="badge badge-danger right">{{ $unviewed }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('access-outbox', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'access-outbox') active @endif">
                                <i class="nav-icon fas fa-download"></i>
                                <p>
                                    From??????????????????
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3">??????????????????</li>
                        <li class="nav-item">
                            <a href="{{ route('access-material-storage', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'access-material-storage') active @endif">
                                <i class="nav-icon fas fa-server"></i>
                                <p>??????????????????</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('access-taxation-history', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'access-taxation-history') active @endif">
                                <i class="nav-icon fas fa-file-video"></i>
                                <p>
                                    ??????????????????????????????
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('access-notification-history', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'access-notification-history') active @endif">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    ???????????????????????????
                                </p>
                            </a>
                        </li>


                        <li class="nav-header mt-3">?????????</li>
                        <li class="nav-item">
                            <a href="{{ route('video-creation', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'create-video') active @endif">
                                <i class="nav-icon fas fa-video"></i>
                                <p>
                                    ??????????????????
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('video-list', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'video-list') active @endif">
                                <i class="nav-icon fas fa-photo-video"></i>
                                <p>
                                    ???????????????
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('view-registration-information', ['client_id' => $hashids->encode($client->id)]) }}"
                                class="nav-link @if (request()->route()->getName() == 'view-registration-information') active @endif">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    ????????????
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

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    @yield('extra-scripts')

</body>

</html>
