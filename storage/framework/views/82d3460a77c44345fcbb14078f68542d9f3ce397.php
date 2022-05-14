

<?php $__env->startSection('extra-css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h4 class="card-title">

                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped tabled-bordered" id="storedMaterialsTable">
                                    <thead class="bg-primary text-bold">
                                        <th>年</th>
                                        <th>月と日付</th>
                                        <th>時間</th>
                                        <th>承認・保留PDF</th>
                                        <th>対象ファイル</th>
                                        <th>日付</th>
                                        <th>承認者</th>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e(date_format($material->request_sent_at, 'Y年')); ?></td>
                                                <td><?php echo e(date_format($material->request_sent_at, 'm月d日')); ?></td>
                                                <td><?php echo e(date_format($material->request_sent_at, 'H:i')); ?></td>
                                                <td>
                                                    <a href="#"
                                                        onclick="downloadDocumentFiles(<?php echo e($material->pdf->id); ?>)" role="button"><?php echo e($material->pdf->name); ?></a>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        onclick="downloadDocumentFiles(<?php echo e($material->document->id); ?>)" role="button"><?php echo e($material->document->name); ?></a>
                                                </td>
                                                <td>
                                                    <?php switch($material->is_approved):
                                                        case (0): ?>
                                                        <?php case (1): ?>
                                                            <span class="text-gray"><i class="fa fas fa-circle"></i> 承認不要データ
                                                                •</span>
                                                        <?php break; ?>

                                                        <?php case (2): ?>
                                                            <span class="text-success"><i class="fa fas fa-check"></i> 承認済み
                                                                •</span>
                                                        <?php break; ?>

                                                        <?php case (3): ?>
                                                            <span class="text-danger"><i class="fa fas fa-ban"></i> 保留 •</span>
                                                        <?php break; ?>

                                                        <?php default: ?>
                                                            <span class="text-gray"><i class="fa fas fa-circle"></i>承認不要データ
                                                                •</span>
                                                    <?php endswitch; ?>
                                                    <?php echo e(date_format($material->response_completed_at, 'Y年m月d日H:i')); ?>

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
                </div>
            </section>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('extra-scripts'); ?>
        <script>
             function downloadDocumentFiles(id) {
                    var url = "<?php echo e(route('download-document-files')); ?>"

                    axios.post(url, {
                        file_id: id
                    }).then(function(response) {
                        const link = document.createElement('a')
                        link.href = response.data[0]
                        link.download = response.data[1];
                        link.click();
                    }).catch(function(error) {
                        console.log(error.response);
                    })
                }
            $(document).ready(function() {
                $('#storedMaterialsTable').DataTable();
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/host/individual-clients/stored-materials.blade.php ENDPATH**/ ?>