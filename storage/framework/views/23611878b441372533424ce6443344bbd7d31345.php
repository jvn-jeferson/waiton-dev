<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-md-8 text-center">
                <h4 class="text-bold">
                    保管情報へのアクセス
                </h4>
                <p class="lead text-left mt-5">
                    メールに記載されたワンタイムパスワードを入力してください。<br>
                    有効期限は24時間です。
                </p>
                <form action="<?php echo e(route('one-time-access', ['record_id' => $access_id])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="password" name="password" id="password" class="form-control text-center <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger">
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <button class="btn btn-warning col-2 offset-5 btn-block mt-2" type="submit">閲覧する</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/client/access_record_verification.blade.php ENDPATH**/ ?>