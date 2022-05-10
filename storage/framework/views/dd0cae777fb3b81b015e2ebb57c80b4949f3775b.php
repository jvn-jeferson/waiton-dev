

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-md-8 text-center">
                <h4 class="text-bold">
                    パスワードは正常に更新されました。
                </h4>
                <p class="lead">
                    <a href="<?php echo e(route('signin', ['user_type' => '会計事務所'])); ?>" class="btn btn-primary">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/auth/passwords/password_change_success.blade.php ENDPATH**/ ?>