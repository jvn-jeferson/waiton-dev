

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title text-dark text-bold">
                                過去の決算
                            </h3>
                            <a class="btn btn-primary col-2 float-right"
                                href="<?php echo e(route('create-video', ['client_id' => $hashids->encode($client->id)])); ?>">
                                新規登録
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped text-center">
                                    <thead class="thead-dark">
                                        <th>種類</th>
                                        <th>決算日</th>
                                        <th>提出済み申告書一式</th>
                                        <th>承認日 • 提出日</th>
                                        <th>説明動画</th>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $archives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $archive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td>
                                                    <?php echo e($archive->kinds ?? ''); ?> <br>
                                                    <a class="btn btn-primary" type="button" data-toggle="tooltip"
                                                        data-placement="top" title="ACCESS FILE"
                                                        href="<?php echo e(route('access-data-financial-record', ['record_id' => $hashids->encodeHex($archive->id), 'client_id' => $hashids->encode($client->id)])); ?>">アクセス</a>
                                                </td>
                                                <td>
                                                    <?php if($archive): ?>
                                                        <?php echo e($archive->settlement_date->format('Y年m月d日')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-info">
                                                    <?php if($archive): ?>
                                                        <?php echo e($archive->file->name ?? ''); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($archive): ?>
                                                        <?php echo e($archive->recognition_date->format('Y年m月d日')); ?> •
                                                        <?php echo e($archive->proposal_date->format('Y年m月d日')); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td class="align-items-center text-center justify-content-center">
                                                    <center>
                                                        <video
                                                            style="width: 50%; border:2px darkgreen dashed; position: relative; display:flex">
                                                            <source src=" <?php if($archive): ?>
                                                            <?php echo e($archive->video_url); ?>

                                                            <?php endif; ?>">
                                                        </video>
                                                    </center>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="5"></td>
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
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/host/individual-clients/financial-history.blade.php ENDPATH**/ ?>