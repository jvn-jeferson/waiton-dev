<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    対象顧客への連絡
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-dark h4">向けに連絡を行うことができます</p>
                                <form method="post" id="messageClientForm" action="<?php echo e(route('message-client')); ?>" enctype="multipart/form-data">
                                    <div class="m-3 p-3 alert-info">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="client_id" id="client_id" value="<?php echo e($client->id); ?>">
                                            <div class="form-group">
                                                <label for="scheduled_at">指定日（設定しない場合は、投稿日で連絡されます）</label>
                                                <input type="date" name="scheduled_at" id="scheduled_at" class="form-control" min="<?php echo e(date('Y-m-d')); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="content">コメント欄</label>
                                                <textarea name="content" id="content" rows="5"  class="form-control" placeholder="コメントを投稿 "></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="attachment">ファイルを添付</label>
                                                <input type="file" name="attachment" id="attachment">
                                            </div>
                                    </div>
                                    <input type="submit" value="登録" name="submit" class="btn btn-warning float-right mx-3 col-2">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-success card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title text-dark">投稿履歴</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="thead bg-light">
                                            <th>選択</th>
                                            <th>投稿日</th>
                                            <th>指定日</th>
                                            <th>コメント</th>
                                            <th>投稿資料</th>
                                        </thead>
                                        <tbody>
                                            <button class="btn btn-primary btn-block col-3 mb-3">選択した投稿を削除</button>
                                            <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><input type="checkbox" name="select" id="select" value="<?php echo e($message->id); ?>"></td>
                                                    <td><?php echo e($message->created_at->format('Y年m月d日')); ?></td>
                                                    <td><?php echo e($message->scheduled_at->format('Y年m月d日')); ?></td>
                                                    <td><?php echo nl2br($message->contents); ?></td>
                                                    <td class="text-info">
                                                        <?php if($message->file): ?>
                                                            <a href="#" onclick="downloadFile(<?php echo e($message->file->id); ?>, this)"><?php echo e($message->file->name); ?></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-info">クライアント<strong class="text-success"><?php echo e($client->name); ?></strong>を対象としたメッセージはありません。</td>
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
        $(function() {
            $('form').submit(function(e) {
                Swal.showLoading()
            })
        })

        function downloadFile(id, button)
        {
            var url = "<?php echo e(route('download-document-files')); ?>"

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
                    text: error.message,
                    icon: 'danger',
                    showCancelButton: false
                })
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/host/individual-clients/message-client.blade.php ENDPATH**/ ?>