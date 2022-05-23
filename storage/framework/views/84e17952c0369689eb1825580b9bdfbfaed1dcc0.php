<?php $__env->startSection('content'); ?>
<div class="container p-5">
    <div class="card">
        <div class="card-header text-center">
            <h3 class="card-title text-bold">登録情報</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="<?php echo e(route('registration')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light">事務所名</th>
                            <th>
                                <div class="form-group">
                                    <label for="name"><i class="zmdi zmdi-home material-icons-name"></i></label>
                                    <input type="text" name="name" id="name" class="<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name')); ?>" autocomplete="name" placeholder="事務所名"/>
                                    <?php $__errorArgs = ['name'];
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
                            </th>
                        </tr>
                        <tr>
                            <td class="bg-light">代表者</td>
                            <td>
                                <div class="form-group">
                                    <label for="representative"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                    <input type="text" name="representative" id="representative" class="<?php $__errorArgs = ['representative'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('representative')); ?>" autocomplete="representative" placeholder="代表者"/>
                                    <?php $__errorArgs = ['representative'];
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
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light">所在地</td>
                            <td>
                                <div class="form-group">
                                    <label for="address"><i class="zmdi zmdi-pin-drop material-icons-name"></i></label>
                                    <input type="text" name="address" id="address" class="<?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('address')); ?>" autocomplete="address" placeholder="所在地">
                                    <?php $__errorArgs = ['address'];
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
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light">電話番号</td>
                            <td>
                                <div class="form-group">
                                    <label for="telephone"><i class="zmdi zmdi-phone material-icons-name"></i></label>
                                    <input type="text" name="telephone" id="telephone" class="<?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('telephone')); ?>" autocomplete="telephone" placeholder="電話番号">
                                    <?php $__errorArgs = ['telephone'];
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
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light">メールアドレス</td>
                            <td>
                                <div class="form-group">
                                    <label for="email"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                    <input type="email" name="email" id="email" class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" autocomplete="email" placeholder="メールアドレス">
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
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justify-content-center"><input type="submit" value="登録" class="btn btn-warning btn-flat"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/auth/register.blade.php ENDPATH**/ ?>