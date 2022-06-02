<?php $__env->startSection('content'); ?>
    <div class="container p-5">
        <div class="card p-2 justify-content-center align-items-center">
            <div class="card-header">
                <h3 class="card-title text-center">パスワード再設定メールの送信</h3>
            </div>
            <div class="card-body text-center">
                <h3 class="mt-2">
                    <strong>
                        ご登録いただきましたメールアドレスを入力して送信を行ってください。
                    </strong>
                </h3>
                <h4 class="lead mt-1">※迷惑メールブロックサービスをご利用の方は <span class="text-success"> @upfiling.jp </span>からのメールを受信できるように設定の変更をお願い致します。</h4>

                <form action="<?php echo e(route('send-password-reset-mail')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mt-5 mx-5">
                        <label for="email_address"><i class="zmdi zmdi-email material-icons-name"></i></label>
                        <input id="email" type="email" placeholder="送信先メールアドレスを入力してください"  class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <div class="col-6 offset-3">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="パスワード再設定メールを送信する"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/auth/passwords/request_reset_password.blade.php ENDPATH**/ ?>