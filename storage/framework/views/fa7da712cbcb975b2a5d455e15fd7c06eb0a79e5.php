

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header text-dark">
                                <h2 class="card-title">アップロードリスト（閲覧期限) <small>以下のファイルがクライアントからアップロードされています。</small></h2>
                                <p class="card-subtitle"></p>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-primary btn-block col-3 my-2" type="button" id="btnDownload">選択ファイルを一括ダウンロード</button>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="thead-dark">
                                            <th>選択</th>
                                            <th>投稿日</th>
                                            <th>閲覧期限</th>
                                            <th>投稿者</th>
                                            <th>投稿資料</th>
                                            <th>コメント</th>
                                            <th>Options</th>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td class="text-center"><input type="checkbox" name="select" id="select" value="<?php echo e($upload->file_id); ?>" <?php if($upload->file_id == null): ?> disabled <?php endif; ?>></td>
                                                    <td><?php echo e($upload->created_at->format('Y年m月d日 H:i')); ?></td>
                                                    <td><?php echo e($upload->created_at->modify('+1 month')->format('Y年m月d日 H:i')); ?></td>
                                                    <td><?php echo e($upload->user->clientStaff->name); ?></td>
                                                    <td class="text-info"><a href="<?php echo e(Storage::disk('gcs')->url($upload->file->path)); ?>" download="<?php echo e($upload->file->name); ?>"><?php echo e($upload->file->name); ?></a></td>
                                                    <td><?php echo e($upload->comment); ?></td>
                                                    <td class="text-center"><?php if($upload->is_viewed == 0): ?> <button class="btn btn-primary" onclick="markAsRead(<?php echo e($upload->id); ?>, this)" role="button">Mark as read</button><?php endif; ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-success">
                                                        クライアントからの新しいアップロードはありません。
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
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
    <script>
        $('#btnDownload').click(function() {
            var checkedBox = document.getElementsByName('select')
            var ids = [];
            for (var checkbox of checkedBox) {
                if(checkbox.checked)
                {
                    id = checkbox.value;

                    var url = "<?php echo e(route('download-file')); ?>"
                    axios.post(url, {
                        file_id: id
                    }).then(function(response) {
                        const link = document.createElement('a')
                        link.href = response.data[0]
                        link.setAttribute('download', response.data[1]);
                        link.click();
                        document.removeChild(link);

                    }).catch(function(error) {
                        console.log(error.response.data);
                    })
                }
            }
        })

        function markAsRead(target, button)
        {
            var url = "<?php echo e(route('mark-as-read')); ?>"

            axios.post(url, {
                record_id: target
            }).then(function(response) {
                button.disabled = 'disabled'
            }).catch(function(error) {
                console.log(error.response);
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/host/individual-clients/incoming.blade.php ENDPATH**/ ?>