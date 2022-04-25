

<?php $__env->startSection('content'); ?>
<div class="container p-5">
    <div class="card">
        <div class="card-header text-center">
            <h3 class="card-title">ログイン (<?php echo e($user_type); ?>)</h3>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <h3 class="lead my-2 text-center">
                    
                </h3>
                    <div class="form-group">
                        <label for="email_address"><i class="zmdi zmdi-email material-icons-name"></i></label>
                        <input id="login_id" type="text" placeholder="ID" class="<?php $__errorArgs = ['login_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="login_id" value="<?php echo e(old('login_id')); ?>" required autocomplete="email" autofocus>
    
                        <?php $__errorArgs = ['login_id'];
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
                        <label for="password"><i class="zmdi zmdi-lock"></i></label>
                        <input id="password" type="password" placeholder="パスワード" class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="password">
                        <?php $__errorArgs = ['password'];
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
                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="offset-5 form-submit" value="ログイン"/>
                    </div>
            </form>
            <?php if($user_type != 'モアジョブ'): ?>
                <h3 class="lead mt-5 text-dark">
                    パスワードをお忘れの方
                </h3>
                <h4 class="lead mt-2">
                    １　利用者は会計事務所の管理者にご連絡いただき、管理者の管理画面からパスワードの修正を行ってください。
                </h4>
                <h4 class="lead mt-2">
                    ２　管理者のパスワードが不明な場合は<strong class="text-bold"><a href="<?php echo e(route('forgot-password')); ?>" class="text-info">こちら</a></strong>から手続きしてください。
                </h4>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/auth/login.blade.php ENDPATH**/ ?>