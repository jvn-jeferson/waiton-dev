

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                連絡事項
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <ul class="list-group list-group-flush">
                                  <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item">
                                      <i class="fas fa-circle <?php if($message->is_global == 0): ?> text-success <?php else: ?> text-primary <?php endif; ?>"></i>
                                      <strong class="<?php if($message->is_global == 0): ?> text-success <?php else: ?> text-primary <?php endif; ?>">
                                        <?php if($message->scheduled_at): ?>
                                        <?php echo e(date_format($message->scheduled_at, 'Y年m月d日')); ?>

                                        <?php else: ?>
                                        <?php echo e($message->created_at->format('Y年m月d日')); ?>

                                        <?php endif; ?>
                                      </strong>
                                      - <?php echo e($message->contents); ?>

                                    </li>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="text-info list-group-item">
                                      新しい通知はありません.
                                    </li>
                                  <?php endif; ?>
                                </ul>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                To会計事務所
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <th>アップロード日</th>
                                        <th>ファイル名</th>
                                        <th>状態</th>
                                        <th>視聴期限</th>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e(date_format($upload->created_at, 'Y年m月d日')); ?></td>
                                                <td class="text-primary"><a href="<?php echo e(url(Storage::disk('gcs')->url($upload->file->path))); ?>" download="<?php echo e($upload->file->name); ?>"><?php echo e($upload->file->name); ?></a></td>
                                                <td>をアップロードしました。</td>
                                                <td><?php echo e($upload->created_at->modify('+1 month')->format('Y年m月d日')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    表示するレコードがありません
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                From会計事務所
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <th>郵送日</th>
                                        <th>ファイル名</th>
                                        <th>状態</th>
                                        <th>確認状況</th>
                                        <th>視聴期限</th>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                           <tr>
                                               <td><?php echo e($download->created_at->format('Y年m月d日')); ?></td>
                                               <td class="text-info"><?php if($download->file): ?> <a href="<?php echo e(Storage::disk('gcs')->url($download->file->path)); ?>" download="<?php echo e($download->file->name); ?>"><?php echo e($download->file->name ?? ''); ?><?php endif; ?></a></td>
                                               <td>
                                                   <?php switch($download->status):
                                                        case (1): ?>
                                                            UPLOADED
                                                            <?php break; ?>
                                                        <?php case (2): ?>
                                                            ADMITTED
                                                            <?php break; ?>
                                                        <?php case (3): ?>
                                                            RESERVED
                                                            <?php break; ?>
                                                        <?php default: ?>
                                                            <?php echo e(""); ?>

                                                            <?php break; ?>
                                                    <?php endswitch; ?>
                                               </td>
                                               <td>
                                                   <?php if($download->priority > 0): ?>
                                                    確認依頼あり
                                                   <?php else: ?>
                                                    <?php echo e(""); ?>

                                                    <?php endif; ?>
                                                </td>
                                               <td><?php echo e($download->created_at->modify('+1 month')->format('Y年m月d日')); ?></td>
                                           </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                           <tr>
                                               <td colspan="5" class="text-center text-info">
                                                表示するレコードがありません
                                               </td>
                                           </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title text-bold">
                                資料の保管
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <th>アップロード日</th>
                                        <th>ファイル名</th>
                                        <th>状態</th>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($upload->created_at->format('Y年m月d日')); ?></td>
                                                <td><a href="<?php echo e(Storage::disk('gcs')->url($upload->file->path)); ?>" download="<?php echo e($upload->file->name); ?>"><?php echo e($upload->file->name); ?></a></td>
                                                <td>が保存されました。</td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-info">
                                                表示するレコードがありません
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/host/individual-clients/dashboard.blade.php ENDPATH**/ ?>