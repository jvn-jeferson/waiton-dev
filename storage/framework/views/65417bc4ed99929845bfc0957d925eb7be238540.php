<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Stripe JS -->


    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo e(asset('fonts/material-icon/css/material-design-iconic-font.min.css')); ?>">

    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo e(asset('css/auth_style.css')); ?>">

    <!-- Pricing CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/pricing.css')); ?>">

    <!-- Stripe CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/stripe.css')); ?>">

    <script src="https://js.stripe.com/v3/"></script>

    <?php echo $__env->yieldContent('extras'); ?>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <?php echo e(config('app.name', 'Laravel')); ?>

                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                            <?php if(Route::has('login')): ?>
                                <div class="dropdown mx-0">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">ログイン <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                    <li class='nav-link'><a href="<?php echo e(route('signin', ['user_type'=> '会計事務所'])); ?>">会計事務所</a></li>
                                    <li class='nav-link'><a href="<?php echo e(route('signin', ['user_type'=> 'クライアント'])); ?>">クライアント</a></li>
                                    <li class='nav-link'><a href="<?php echo e(route('signin', ['user_type'=> 'モアジョブ'])); ?>">モアジョブ</a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <?php if(Route::has('register')): ?>
                                <a href="register" class="btn btn-success mx-2">新規登録</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <?php echo $__env->yieldContent('extra-js'); ?>
</body>
</html>
<?php /**PATH /var/www/html/waiton-dev/resources/views/layouts/app.blade.php ENDPATH**/ ?>