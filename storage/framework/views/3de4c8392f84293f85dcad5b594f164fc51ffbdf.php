<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title text-primary text-bold">
                        登録情報
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">会社名</td>
                                <td class="text-bold">
                                    <?php echo e($account->name); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">当店の場所</td>
                                <td>
                                    <?php echo e($account->address); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">代表</td>
                                <td>
                                    <?php echo e($account->representative); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">代表住宅</td>
                                <td>
                                    <?php echo e($account->representative_address); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">連絡先メールアドレス</td>
                                <td class="text-primary">
                                    <?php echo e($account->contact_email); ?>

                                </td>
                            </tr>

                            <?php if(Auth::user()->role_id == 4): ?>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">NTA識別番号</td>
                                    <td>
                                        <?php if($account->credentials): ?>
                                        <?php echo e($account->credentials->nta_id); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">パスワード</td>
                                    <td class="text-encrypted">

                                        <?php if($account->credentials): ?>
                                        <?php echo e($account->credentials->nta_password); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">E-tax納税者番号</td>
                                    <td>

                                        <?php if($account->credentials): ?>
                                        <?php echo e($account->credentials->el_tax_id); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">パスワード</td>
                                    <td class="text-encrypted">

                                        <?php if($account->credentials): ?>
                                        <?php echo e($account->credentials->el_tax_password); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>

<?php if(Auth::user()->role_id == 4): ?>
            <div class="card card-danger card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-bold">
                        新規登録
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('new-user')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="client_id" value="<?php echo e($account->id); ?>">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td class="bg-gray w-25">
                                    <label class="h4">ユーザータイプ</label>
                                    <?php $__errorArgs = ['staff_role'];
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
                                </td>
                                <td>
                                    <label for="staff_role" class="h4">
                                        <input type="radio" name="staff_role" id="staff_role" class="p-1" value="1">  管理者
                                    </label>
                                </td>
                                <td>
                                    <label for="staff_role" class="h4">
                                        <input type="radio" name="staff_role" id="staff_role" class="p-1" value="0">  利用者
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-gray w-25">
                                    名前
                                    <?php $__errorArgs = ['staff_name'];
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
                                </td>
                                <td colspan="2">
                                    <input type="text" name="staff_name" id="staff_name" class="form-control flat">
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-gray w-25 text-bold">
                                    メールアドレス
                                    <?php $__errorArgs = ['staff_email'];
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
                                </td>
                                <td colspan="2">
                                    <input type="email" name="staff_email" id="staff_email" class="form-control flat">
                                </td>
                            </tr>
                        </table>
                        <button class="col-2 btn btn-warning btn-block float-right" type="submit" name="submit">新規登録</button>
                    </form>
                    </div>
                </div>
            </div>

            <div class="card card-danger card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-bold">
                        ログイン情報
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="3" class="bg-teal disabled"></td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <?php if(auth()->user()->role_id == 4): ?><button class="btn btn-warning" data-toggle="modal" data-target="#contactEmailModal">編集</button><?php endif; ?>
                                </td>
                                <td class="w-25 text-bold">
                                    ワンタイムパスワードの • 送付先メールアドレス
                                </td>
                                <td class="bg-gray">
                                    <?php echo e($account->contact_email); ?>

                                </td>
                            </tr>
                            <?php $__empty_1 = true; $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td colspan="3" class="bg-teal disabled"></td>
                                </tr>
                                <tr>
                                    <td class="text-center text-bold rowspan="2">
                                        <?php if($staff->is_admin == 1): ?>
                                            管理者
                                        <?php else: ?>
                                            利用者
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        ID
                                    </td>
                                    <td>
                                        <?php echo e($staff->user->login_id); ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>名前</td>
                                    <td><?php echo e($staff->name); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <?php if(auth()->user()->role_id == 4): ?>
                                            <button class="btn btn-warning" role="button" onclick="editUser(<?php echo e($staff->user->id); ?>)">編集</button>
                                        <?php endif; ?>
                                    </td>
                                    <td>パスワード</td>
                                    <td class="bg-gray">**********</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        <?php if(auth()->user()->role_id == 4): ?>
                                            <button class="btn btn-danger" role="button" onclick="deleteStaff(<?php echo e($staff->id); ?>)">削除</button>
                                        <?php endif; ?>
                                    </td>
                                    <td>メールアドレス</td>
                                    <td class="bg-gray"><?php echo e($staff->user->email); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>

            <?php endif; ?>
        </section>
    </div>

    <div class="modal fade" id="contactEmailModal" tabindex="-1" aria-labelledby="contactEmailModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactEmailModalLabel">送付先メールアドレス</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form action="<?php echo e(route('update-contact-email-client')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($account->id); ?>">
                            <table class="table table-bordered">
                                <thead>
                                    <th>
                                        <input type="email" name="contact_email" id="contact_email" class="form-control" value="<?php echo e($account->contact_email); ?>">
                                    </th>
                                    <th>
                                        <button class="btn btn-block btn-warning" type="submit">編集</button>
                                    </th>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Update User Information
                    </h4>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <form action="<?php echo e(route('update-staff-client')); ?>" method="post">
                    <input type="hidden" name="userID" id="userID">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>
                                            名前
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" id="userName" name="userName">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            メールアドレス
                                        </th>
                                        <td>
                                            <input type="email" class="form-control" id="userEmail" name="userEmail">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            ユーザーID
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" id="userLogin" name="userLogin" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>New Password</th>
                                        <td>
                                            <input type="password" name="userPassword" id="userPassword" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="float-right btn btn-primary" type="submit">変更</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('extra-scripts'); ?>

<script>
    $(function() {
        $('form').submit(function(e) {
            Swal.showLoading()
        })
    })

    function editUser(user_id)
        {
            var url = "<?php echo e(route('get-user-client')); ?>";
            var name, email;
            var userModal = $('#userModal');
            axios.post(url, {
                id: user_id,
            }).then(function(response) {
                name = response.data['name']
                email = response.data['email']
                id = response.data['id']
                login_id = response.data['login_id']
                remember_token = response.data['token']

                $('#userName').val(name)
                $('#userEmail').val(email)
                $('#userLogin').val(login_id)
                $('#userID').val(id)
                userModal.modal('show');

            }).catch(function(error) {
                console.log(error.response.data)
            })
        }

        //delete user
        function deleteStaff(staff_id)
        {
            Swal.fire({
                title: '本当に削除しますか？',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'キャンセル',
                preConfirm: function() {
                    var url = "<?php echo e(route('delete-ca-staff')); ?>"

                    return axios.post(url, {
                        id : staff_id
                    }).then(function(response) {

                    }).catch(function(error) {
                        console.log(error.response.data)
                        return false
                    })
                },
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading()
            }).then(() => {
                Swal.fire({
                            title: '削除完了しました。',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000,
                            allowOutsideClick: false
                        }).then((result) => {
                            if(result.dismiss == Swal.DismissReason.timer){
                                location.reload()
                            }
                        })
            })


        }
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/client/settings.blade.php ENDPATH**/ ?>