<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center p-0">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-left">
                        <h3 class="card-title text-dark text-bold">
                            保存資料（動画なし）
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="bg-info text-bold text-center">
                                    <th>種類</th>
                                    <th>資料</th>
                                    <th>投稿者</th>
                                </thead>
                                <tbody>
                                    <?php if($record): ?>
                                        <tr class="text-center">
                                            <td class="text-bold">
                                                <?php echo e($record->notification_type ?? '不明'); ?>

                                            </td>
                                            <td>
                                                <a href="#" onclick="downloadFile(<?php echo e($record->file->id); ?>, this)"><?php echo e($record->file->name); ?></a>
                                            </td>
                                            <td>
                                                <?php echo e($record->uploader->name); ?>

                                            </td>
                                        </tr>
                                    <?php else: ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="notifDataModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">レコード番号 : <strong id="notif_id"></strong> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Temporary waiting for additional data.
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-js'); ?>

    <script>

        function showNotifData(id)
        {
            var notifDataModal = document.querySelector('#notifDataModal')

            notifDataModal.modal('show')
        }

        function downloadFile(id, button)
        {
            var url = "<?php echo e(route('download')); ?>"

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/client/view_archived_notif.blade.php ENDPATH**/ ?>