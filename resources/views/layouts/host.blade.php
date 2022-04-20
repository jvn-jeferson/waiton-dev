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

<body class="hold-transition sidebar-mini dark-mode">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WV7L6QS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item ml-3">
                    <a href="#" class="nav-link text-bold">{{ $page_title }}</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ Auth::user()->accountingOffice->name ?? '' }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('img/user-icon.png') }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">
                                    {{ Auth::user()->accountingOfficeStaff->name ?? '' }}
                                </h3>

                                <p class="text-muted text-center text-bold">
                                    {{ Auth::user()->role->display_name ?? '' }}
                                </p>

                                <ul class="list-group list-group-unbordered mb-3">

                                </ul>

                                <a href="{{ route('account') }}" class="btn btn-primary btn-block"><b>顧客情報</b></a>

                                <a href="{{ url('/logout') }}" class="btn btn-danger btn-block"><b>ログアウト</b></a>
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
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('img/w-logo-green.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('img/user-icon.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ route('account') }}"
                            class="d-block">{{ Auth::user()->accountingOffice->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('home') }}"
                                class="nav-link  @if (request()->route()->getName() == 'home') active @endif">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    事務所ホーム
                                </p>
                            </a>
                        </li>
                        <li class="nav-item mt-3">
                            <a href="{{ route('clients') }}"
                                class="nav-link @if (request()->route()->getName() == 'clients') active @endif">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    顧客の選択
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('outbox') }}"
                                class="nav-link @if (request()->route()->getName() == 'outbox') active @endif">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>
                                    全顧客への連絡
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('clients-information') }}"
                                class="nav-link  @if (request()->route()->getName() == 'clients-information') active @endif">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    顧客の一覧
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3 ml-2">
                            事務所内の管理
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('account') }}"
                                class="nav-link @if (request()->route()->getName() == 'account') active @endif">
                                <i class="nav-icon fa fa-cog"></i>
                                <p>
                                    メンバー管理
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('account') }}"
                                class="nav-link @if (request()->route()->getName() == 'accounting-profile') active @endif">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>
                                    プラン確認・変更
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mt-5">
                            <a href="" class="nav-link">
                                <i class="nav-icon far fa-question-circle"></i>
                                <p>
                                    FAQ
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" id="inquiryBtn">
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



    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('extra-scripts')

    <script>
        $('#inquiryBtn').click(async () => {
            const {
                value: text
            } = await Swal.fire({
                icon: 'question',
                input: 'textarea',
                inputLabel: 'Inquiry',
                inputPlaceholder: 'Type your inquiry here... We will send you and email to your registered email address.',
                inputAttributes: {
                    'aria-label': 'Type your inquiry here..'
                },
                showCancelButton: false
            })

            if (text) {
                var url = "{{ route('send-host-inquiry') }}"

                axios.post(url, {
                    content: text,
                }).then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'SUCCESS',
                        text: 'Inquiry has been sent successfully.'
                    })
                }).catch(function(error) {
                    console.log(error.response.data)
                })
            }
        })
    </script>
</body>

</html>
