

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">
                            届出サマリー
                        </h3>
                        <button class="float-right btn btn-warning col-2" type="button" data-toggle="modal" data-target="#updateNotificationModal">変更・登録</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="w-25 text-bold" rowspan="5">主要な届出等の状況</td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="defaultCheck1" <?php if($client->notifs->establishment_notification): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                設立（開業）届出書
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->blue_declaration): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                青色申告の申請
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->withholding_tax): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                源泉所得税の納期の特例
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->salary_payment): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                給与支払事務所等の届出
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->extension_filing_deadline): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                申告期限の延長申請
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">

                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->consumption_tax): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                消費税の課税事業者
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->consumption_tax_excemption): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                消費税の免税事業者の届出
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-gray">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" <?php if($client->notifs->consumption_tax_selection): ?> checked <?php endif; ?>>
                                            <label class="form-check-label" for="defaultCheck1">
                                                消費税の課税事業者の選択届出書
                                            </label>
                                        </div>
                                    </td>
                                    <td class="bg-gray">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">
                            過去の届出等の履歴
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <button class="float-right col-2 button btn-warning btn my-2" type="button" data-toggle="modal" data-target="#newNotificationModal">新規登録</button>
                            <table class="table table-bordered text-center">
                                <thead class="bg-lightblue">
                                    <th>種類</th>
                                    <th>提出日</th>
                                    <th>承認日</th>
                                    <th class="w-50">資料</th>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td></td>
                                            <td><?php echo e($archive->proposal_date->format('Y年m月d日')); ?></td>
                                            <td><?php echo e($archive->recognition_date->format('Y年m月d日')); ?></td>
                                            <td class="text-info"><a href="<?php echo e(Storage::disk('gcs')->url($archive->file->path)); ?>" download="<?php echo e($archive->file->name); ?>"><?php echo e($archive->file->name); ?></a></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


<div class="modal fade" id="newNotificationModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="newNotificationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newNotificationModalLabel">新規登録フォーム</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <form action="<?php echo e(route('save-notification-archive', ['client_id' => $client->id])); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <table class="table-bordered bg-light table">
                            <tbody>
                                <tr>
                                    <td class="w-100">
                                        <label class="text-bold" for="notification_type">種類</label>
                                        <div class="form-group px-auto">
                                            <div class="form-check form-check-inline mr-5">
                                                <input class="form-check-input" type="radio" id="notification_type1" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type1">異動届</label>
                                            </div>
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" id="notification_type2" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type2">届出</label>
                                            </div>
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" id="notification_type3" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type3">申請</label>
                                            </div>
                                            <div class="form-check form-check-inline mx-5">
                                                <input class="form-check-input" type="radio" id="notification_type4" name="notification_type" value="option1">
                                                <label class="form-check-label" for="notification_type4">その他</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-row">
                                            <label for="proposal_date" class="col-sm-2 col-form-label">提出日</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="proposal_date" name="proposal_date" placeholder="Email">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-row">
                                            <label for="recognition_date" class="col-sm-2 col-form-label">承認日</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" id="recognition_date" name="recognition_date" placeholder="Email">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group form-row">
                                            <label for="attachment" class="col-sm-2 col-form-label">資料</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" id="file" name="file" placeholder="Email">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">新規登録</button>
            </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="updateNotificationModal" tabindex="-1" role="dialog" aria-labelledby="updateNotificationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateNotificationModalLabel">届出サマリー</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('update-notification-settings')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center bg-dark">
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="establishment_notification" id="establishment_notification" value="1" >
                                        <label class="form-check-label" for="establishment_notification">
                                            設立（開業）届出書
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="blue_declaration" id="blue_declaration" value="1" >
                                        <label class="form-check-label" for="blue_declaration">
                                            青色申告の申請
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="withholding_tax" id="withholding_tax" value="1" >
                                        <label class="form-check-label" for="withholding_tax">
                                            源泉所得税の納期の特例
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="salary_payment" id="salary_payment" value="1" >
                                        <label class="form-check-label" for="salary_payment">
                                            給与支払事務所等の届出
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="extension_filing_deadline" id="extension_filing_deadline" value="1" >
                                        <label class="form-check-label" for="extension_filing_deadline">
                                            申告期限の延長申請
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="consumption_tax" id="consumption_tax" value="1" >
                                        <label class="form-check-label" for="consumption_tax">
                                            消費税の課税事業者
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="consumption_tax_excemption" id="consumption_tax_excemption" value="1">
                                        <label class="form-check-label" for="consumption_tax_excemption">
                                            消費税の免税事業者の届出
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="consumption_tax_selection" id="consumption_tax_selection" value="1">
                                        <label class="form-check-label" for="consumption_tax_selection">
                                            消費税の課税事業者の選択届出書
                                        </label>
                                    </div>
                                </td>
                                <td>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="float-right btn btn-primary" type="submit">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/host/individual-clients/notification-history.blade.php ENDPATH**/ ?>