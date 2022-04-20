

<?php $__env->startSection('extra-css'); ?>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <strong class="text-info">現在の通知ステータス</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table-bordered table">
                        <tbody>
                            <tr>
                                <td class="text-bold bg-lightblue">会社名</td>
                                <td class="text-dark text-bold">
                                    <?php echo e($account->name); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue">当店の場所</td>
                                <td>
                                    <?php echo e($account->address); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue">代表</td>
                                <td>
                                    <?php echo e($account->representative); ?>

                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue">代表住宅</td>
                                <td>
                                    <?php echo e($account->representative_address); ?>

                                </td>
                            </tr>
                            <tr>
                                <td rowspan="8" class="text-bold bg-lightblue">主要な通知の状況など</td>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->establishment_notification == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    設立通知フォーム
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->blue_declaration == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    青色申告の申請
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->withholding_tax == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    源泉徴収税の特別納期
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->salary_payment == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    給与支給事務所等への通知
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->extension_filing_deadline == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    提出期限延長の申請
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->consumption_tax == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    消費税課税事業者
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->consumption_tax_excemption == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    消費税免税事業者への通知
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled <?php if($account->notifs): ?> <?php if($account->notifs->consumption_tax_selection == 1): ?>checked <?php endif; ?> <?php endif; ?>>
                                    消費税課税事業者選定通知書
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-primary">
                    <div class="card-header">
                        過去の届出等へのアクセス
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="bg-info text-bold">
                                    <th>種類</th>
                                    <th>アップロード日</th>
                                    <th>資料</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="text-center">
                                            <td class="w-25">
                                                <?php if($record->notification_type): ?>
                                                <?php echo e($record->notification_type); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo e($record->created_at->format('Y年m月d日')); ?>

                                            </td>
                                            <td class="w-50">
                                                <span class="text-info"><?php echo e($record->file->name); ?></span>
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-block" type="button" onclick="confirmAccessRequest(<?php echo e($record->id); ?>)">閲覧</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-info">
                                                レコードが見つかりません。
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
    <script>
        function confirmAccessRequest(id) {
            Swal.fire({
                title: "機密情報へのアクセスの閲覧",
                text: "登録したメールアドレスにワンタイムパスワードが送信されますので、メールアドレスのURLからログインしてアクセスしてください。",
                showCancelButton: !0,
                confirmButtonText: "閲覧する",
                cancelButtonText: "キャンセル",
                reverseButtons: false
            }).then((result) => {
                if(result.isConfirmed)
                {
                    var url = "<?php echo e(route('send-otp')); ?>";
                    axios.post(url, {
                        record_id: id,
                        table: 'past_notifications',
                        record_id: id
                    }).then(function(response) {
                        Swal.fire({
                            title: '成功',
                            icon: 'success',
                            text: '登録したメールアドレスにワンタイムパスワードが送信されました。 メールを確認し、手順に従ってアクセスしてください。'
                        })
                    }).catch(function(error){
                        Swal.fire({
                            title: 'エラー',
                            icon: 'warning',
                            text: 'エラーが発生しました。 もう一度やり直してください。'
                        })
                    })
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/client/notif-history.blade.php ENDPATH**/ ?>