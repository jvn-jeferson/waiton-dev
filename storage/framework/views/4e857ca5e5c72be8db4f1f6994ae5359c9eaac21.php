<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="<?php echo e(asset('toppage_data/favicon.ico')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('toppage_data/apple-touch-icon.png')); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name')); ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
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
    <?php echo $__env->yieldContent('extra-css'); ?>
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
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link text-bold" href="#"><?php echo e($page_title); ?></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <?php echo e(Auth::user()->clientStaff->client->name ?? ''); ?>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="<?php echo e(asset('img/user-icon.png')); ?>" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">
                                    <?php if(Auth::user()->clientStaff->is_admin == 1): ?>
                                        Administrator
                                    <?php else: ?>
                                        Staff
                                    <?php endif; ?>
                                </h3>

                                <p class="text-muted text-center">
                                    <?php echo e(Auth::user()->clientStaff->name); ?>

                                </p>

                                <ul class="list-group list-group-unbordered mb-3">

                                </ul>

                                <a href="various-settings" class="btn btn-primary btn-block"><b>Profile</b></a>

                                <a href="<?php echo e(url('/logout')); ?>" class="btn btn-danger btn-block"><b>ログアウト</b></a>
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
            <a href="<?php echo e(route('client-home')); ?>" class="brand-link logo-switch text-center">
                <img src="<?php echo e(asset('img/upfiling_logo_xl.png')); ?>" alt="UPF Logo"
                    class="brand-image-xs logo-xl my-auto mx-auto" > <span class="brand-text font-weight-light"><?php echo e(config('app.name')); ?></span>
                <img src="<?php echo e(asset('img/upfiling_logo_xs.png')); ?>" alt="UPF Logo"
                    class="brand-image-xl logo-xs my-auto mx-auto" >
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo e(asset('img/user-icon.png')); ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="various-settings" class="d-block">
                            <?php echo e(auth()->user()->clientStaff->client->name); ?>

                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?php echo e(route('client-home')); ?>"
                                class="nav-link  <?php if(request()->route()->getName() == 'client-home'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    ホーム
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3">文書</li>
                        <li class="nav-item">
                            <a href="data-outgoing" class="nav-link <?php if(request()->route()->getName() == 'data-outgoing'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-upload"></i>
                                <p>
                                    To　会計事務所
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="data-incoming" class="nav-link <?php if(request()->route()->getName() == 'data-incoming'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-download"></i>
                                <p>
                                    From　会計事務所
                                    <span class="right badge badge-danger">
                                        <?php if($for_approval > 0): ?>
                                            <?php echo e($for_approval); ?>

                                        <?php endif; ?>
                                    </span>
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3">資料フォルダ</li>
                        <li class="nav-item">

                            <a href="material-storage" class="nav-link <?php if(request()->route()->getName() == 'material-storage'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-server"></i>
                                <p>確認済の資料</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="settlement-history"
                                class="nav-link <?php if(request()->route()->getName() == 'settlement-history'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-file-video"></i>
                                <p>
                                    保管資料（動画あり）
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="notification-history"
                                class="nav-link <?php if(request()->route()->getName() == 'notification-history'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    保管資料（その他）
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-3">ツール</li>
                        <li class="nav-item">
                            <a href="various-settings" class="nav-link <?php if(request()->route()->getName() == 'various-settings'): ?> active <?php endif; ?>">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    各種設定
                                </p>
                            </a>
                        </li>

                        <li class="nav-header mt-5"></li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('client-faq')); ?>" class="nav-link">
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
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript" src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                var url = "<?php echo e(route('send-inquiry')); ?>"

                axios.post(url, {
                    content: text
                }).then(function(response) {
                    console.log(response.data)
                }).catch(function(error) {
                    Swal.fire({
                        icon: 'danger',
                        title: 'ERROR',
                        text: 'An error has occured.'
                    })
                })
            }
        })
    </script>
    <?php echo $__env->yieldContent('extra-scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\waiton-dev\resources\views/layouts/client.blade.php ENDPATH**/ ?>