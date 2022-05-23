<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="text-bold card-title">
                            確認済の資料
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped tabled-bordered">
                                <thead class="bg-primary text-bold">
                                    <th></th>
                                    <th>承認・保留PDF</th>
                                    <th>対象ファイル</th>
                                    <th>日付</th>
                                    <th>承認者</th>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(date_format($material->request_sent_at, 'Y年m月d日H:i') ?? ''); ?></td>
                                            <td> <a href="#" onclick="downloadDocumentFiles(<?php echo e($material->pdf->id); ?>, this)"
                                                    role="button"><?php echo e($material->pdf->name); ?></a></td>
                                            <td> <a href="#"
                                                    onclick="downloadDocumentFiles(<?php echo e($material->document->id); ?>, this)"
                                                    role="button"><?php echo e($material->document->name ?? ''); ?></a>
                                            </td>
                                            <td>
                                                <?php switch($material->is_approved):
                                                    case (0): ?>
                                                    <?php case (1): ?>
                                                        <span class="text-gray"><i class="fa fas fa-circle"></i> 承認不要データ
                                                            •</span>
                                                    <?php break; ?>

                                                    <?php case (2): ?>
                                                        <span class="text-success"><i class="fa fas fa-check"></i> 承認済み •</span>
                                                    <?php break; ?>

                                                    <?php case (3): ?>
                                                        <span class="text-danger"><i class="fa fas fa-ban"></i> 保留 •</span>
                                                    <?php break; ?>

                                                    <?php default: ?>
                                                        <span class="text-gray"><i class="fa fas fa-circle"></i>承認不要データ
                                                            •</span>
                                                <?php endswitch; ?>
                                                <?php echo e(date_format($material->response_completed_at, 'Y年m月d日H:i') ?? ''); ?>

                                            </td>
                                            <td><?php echo e($material->viewer->name ?? ''); ?></td>
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
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('extra-scripts'); ?>
        <script>
            function downloadDocumentFiles(id, button)
            {
                var url = "<?php echo e(route('download')); ?>"

                axios.post(url, {
                    file_id: id
                }).then(function (response) {
                    const link = document.createElement('a')
                    link.href = response.data[0]
                    link.setAttribute('download', response.data[1]);
                    link.click();
                    button.disabled = 'disabled'
                }).catch(function (error) {
                    Swal.fire({
                        title: "ERROR",
                        text: error.response.data['message'],
                        icon: 'danger',
                        showCancelButton: false
                    })
                })
            }
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/client/material-storage.blade.php ENDPATH**/ ?>