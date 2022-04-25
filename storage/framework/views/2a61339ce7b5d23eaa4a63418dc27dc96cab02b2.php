<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title><?php echo e(config('app.name')); ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
  <?php echo $__env->yieldContent('extra-css'); ?>
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
        <li class="nav-item ml-3">
          <a href="#" class="nav-link text-bold"><?php echo e($page_title); ?></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <?php echo e(Auth::user()->accountingOffice->name ?? ''); ?>

          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                      src="<?php echo e(asset('img/user-icon.png')); ?>"
                      alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">
                  <?php echo e(Auth::user()->accountingOffice->representative ?? ''); ?>

                </h3>

                <p class="text-muted text-center text-bold">
                  <?php echo e(Auth::user()->role->display_name ?? ''); ?>

                </p>

                <ul class="list-group list-group-unbordered mb-3">

                </ul>

                <a href="<?php echo e(route('account')); ?>" class="btn btn-primary btn-block"><b>顧客情報</b></a>

                <a  href="<?php echo e(url('/logout')); ?>" class="btn btn-danger btn-block"><b>ログアウト</b></a>
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
      <a href="<?php echo e(route('home')); ?>" class="brand-link">
        <img src="<?php echo e(asset('img/w-logo-green.png')); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo e(config('app.name')); ?></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo e(asset('img/user-icon.png')); ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="<?php echo e(route('account')); ?>" class="d-block"><?php echo e(Auth::user()->accountingOffice->name); ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?php echo e(route('home')); ?>" class="nav-link  <?php if(request()->route()->getName() == 'home'): ?> active  <?php endif; ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  事務所ホーム
                </p>
              </a>
            </li>
            <li class="nav-item mt-3">
              <a href="<?php echo e(route('clients')); ?>" class="nav-link <?php if(request()->route()->getName() == 'clients'): ?> active <?php endif; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  顧客の選択
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo e(route('outbox')); ?>" class="nav-link <?php if(request()->route()->getName() == 'outbox'): ?> active <?php endif; ?>">
                <i class="nav-icon fas fa-paper-plane"></i>
                <p>
                  全顧客への連絡
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo e(route('clients-information')); ?>" class="nav-link  <?php if(request()->route()->getName() == 'clients-information'): ?> active <?php endif; ?>">
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
              <a href="<?php echo e(route('account')); ?>" class="nav-link <?php if(request()->route()->getName() == 'account'): ?> active  <?php endif; ?>">
                <i class="nav-icon fa fa-cog"></i>
                <p>
                  メンバー管理
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo e(route('account')); ?>" class="nav-link <?php if(request()->route()->getName() == 'accounting-profile'): ?> active  <?php endif; ?>">
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
      <?php echo $__env->yieldContent('content'); ?>
    </main>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->



  <script type="text/javascript" src="<?php echo e(asset('js/app.js')); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php echo $__env->yieldContent('extra-scripts'); ?>

  <script>
    $('#inquiryBtn').click(async () => {
      const { value: text } = await Swal.fire({
        icon: 'question',
        input: 'textarea',
        inputLabel: 'Inquiry',
        inputPlaceholder: 'Type your inquiry here... We will send you and email to your registered email address.',
        inputAttributes: {
          'aria-label': 'Type your inquiry here..'
        },
        showCancelButton: false
      })

      if(text) {
        var url = "<?php echo e(route('send-host-inquiry')); ?>"

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
<?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/layouts/host.blade.php ENDPATH**/ ?>