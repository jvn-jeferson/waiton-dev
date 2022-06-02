<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12 col-sm-12">

                        <?php if( Session::has('success') ): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong><?php echo e(Session::get('success')); ?></strong>
                        </div>
                        <?php endif; ?>
                        <div class="div card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    事業者一覧
                                </h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-auto"></div>
                                </div>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>新規追加</th>
                                                    <td>
                                                        
                                                        <button class="btn btn-block btn-success float-right" <?php if(auth()->user()->role_id == 2): ?> data-toggle="modal" data-placement="top" title="Add a new customer" data-target="#newClientModal" <?php else: ?> onclick="launchNoAccess()" <?php endif; ?> type="button">
                                                            追加
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-auto">
                                        <h3 class="text-bold">顧客一覧</h3>
                                        <h3 class="text-bold">閲覧する顧客名を選びクイックして下さい。</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-12 col-md-12  table-responsive">
                                        <table class="table mt-2 table-hover table-striped text-center table-bordered">
                                            <thead class="thead bg-info">
                                                <th>事業者名</th>
                                                <th>種類</th>
                                                <th>決算月</th>
                                                <th>新規投稿</th>
                                                <th>確認待ち</th>
                                            </thead>
                                            <tbody>
                                                <?php if($clients): ?>
                                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><a href="<?php echo e(route('access-dashboard', ['client_id' => $hashids->encode($client->id)])); ?>"><?php echo e($client->name); ?></a></td>
                                                            <td><?php if($client->business_type_id == 1): ?> 法人 <?php else: ?> 個人 <?php endif; ?></td>
                                                            <td><?php echo e($client->tax_filing_month); ?>月</td>
                                                            <td></td>
                                                            <td><?php if($client->verified_at == ''): ?> <a href="#" class="btn btn-danger btn-block"><i class="fas fa-circle"></i></a><?php endif; ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5">現在、あなたの会社に登録されているクライアントはありません。 上の新しいクライアントボタンをクリックして登録してください。</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="newClientModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xl " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新しいクライアントを登録する</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="newClientForm">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="pull-left col-4">
                                <h3 class="modal-title">顧客の情報</h3>
                            </div>
                            <div class="col-8">
                                <input type="submit" value="新規登録" class="btn btn-primary btn-block">
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table-bordered table">
                                <tbody>
                                    <tr>
                                        <th colspan="2"><label for="client_name">社名</label></th>
                                        <td>
                                            <div class="form-row">
                                                <div class="col-8">
                                                    <input type="text" autocomplete="off" name="client_name" id="client_name" class="form-control" placeholder="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="radio" name="client_type" id="client_type" value="1" class="mx-auto my-auto">法人
                                                    <input type="radio" name="client_type" id="client_type" value="2" class="mx-auto my-auto">個人
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="client_address">本店所在地</label></th>
                                        <td>
                                            <input type="text" autocomplete="off" name="client_address" id="client_address" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="representative_name">代表者</label></th>
                                        <td>
                                            <input type="text" autocomplete="off" name="representative_name" id="representative_name" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="representative_address">代表者住所</label></th>
                                        <td>
                                            <input type="text" autocomplete="off" name="representative_address" id="representative_address" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="final_accounts_month">決算月</label></th>
                                        <td>
                                            <select name="final_accounts_month" id="final_accounts_month" class="col-auto form-control">
                                                <option value="1">1月</option>
                                                <option value="2">2月</option>
                                                <option value="3">3月</option>
                                                <option value="4">4月</option>
                                                <option value="5">5月</option>
                                                <option value="6">6月</option>
                                                <option value="7">7月</option>
                                                <option value="8">8月</option>
                                                <option value="9">9月</option>
                                                <option value="10">10月</option>
                                                <option value="11">11月</option>
                                                <option value="12">12月</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2"><label for="contact_email_address">ワンタイムパスワードの • 送付先メールアドレス                                             </label></th>
                                        <td>
                                            <input type="email" name="contact_email_address" id="contact_email_address" class="form-control" placeholder="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">管理者</td>
                                        <td>名前</td>
                                        <td><input type="text" autocomplete="off" name="manager_name" id="manager_name" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>メールアドレス</td>
                                        <td><input type="email" name="manager_email" id="manager_email" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">利用者</td>
                                        <td>名前</td>
                                        <td><input type="text" autocomplete="off" name="user1_name" id="user1_name" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>メールアドレス</td>
                                        <td><input type="email" name="user1_email" id="user1_email" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">利用者</td>
                                        <td>名前</td>
                                        <td><input type="text" autocomplete="off" name="user2_name" id="user2_name" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td>メールアドレス</td>
                                        <td><input type="email" name="user2_email" id="uer2_email" class="form-control"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
    <script>
        $("#newClientForm").on('submit', function(event) {

            Swal.showLoading()
            event.preventDefault()
            var type_id = document.querySelector('input[name="client_type"]:checked').value;
            var url = "<?php echo e(route('register-new-client')); ?>";

            axios.post(url, {
                name: $('#client_name').val(),
                business_type_id: type_id,
                address: $('#client_address').val(),
                representative: $('#representative_name').val(),
                representative_address: $('#representative_address').val(),
                tax_filing_month: $('#final_accounts_month').val(),
                email: $('#contact_email_address').val(),
                manager_name: $('#manager_name').val(),
                manager_email: $('#manager_email').val(),
                user1_name: $('#user1_name').val(),
                user1_email: $('#user1_email').val(),
                user2_name: $('#user2_name').val(),
                $user2_email: $('#user2_email').val()

            }).then(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'クライアント登録が成功しました',
                }).then((result) => {
                    if(result.isConfirmed) {
                        window.location.reload();
                    }
                })
            }).catch(function(error) {
                Swal.hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Check your inputs and try again.',
                })
            })
        })


        function launchNoAccess() {
            Swal.fire({
                icon: 'info',
                title: 'アクセスできません',
                text: '新しいクライアントを追加するには、管理者権限が必要です。'
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/host/customer-selection.blade.php ENDPATH**/ ?>