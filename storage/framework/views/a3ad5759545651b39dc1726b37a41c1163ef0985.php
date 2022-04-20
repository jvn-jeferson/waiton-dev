
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-8">
                        <video src="" id="player" width="520" height="600" controls style="border: 1px solid #c6c6c6; background: lightblue" autoplay>
                        </video>
                        <input type="hidden" name="video_player" id="video_player" value="<?php echo e($record->video_url); ?>">
                    </div>
                    <div class="col-4">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th class="text-center">種類</th>
                                    <th><?php echo e($record->kinds); ?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">決算日</td>
                                        <td><?php echo e($record->created_at->format('Y年m月d日')); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">提出済み申告書一式</td>
                                        <td>
                                            <?php echo e($record->file->name); ?> <br>
                                            <a class="btn btn-block btn-warning" type="button" href="<?php echo e(url(Storage::disk('gcs')->url($record->file->path))); ?>" download="<?php echo e($record->file->name); ?>">ダウンロード</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">会社担当者</td>
                                        <td><?php echo e($record->company_representative); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">会計事務所担当者</td>
                                        <td><?php echo e($record->accounting_office_staff); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">動画投稿者</td>
                                        <td><?php echo e($record->video_contributor); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">コメント</td>
                                        <td><?php echo e($record->comment); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var video = document.getElementById('player');
        var video_data = document.getElementById('video_player').value;
        video.setAttribute('src', video_data);
        video.load();
        video.play();
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/client/view_archived_taxation.blade.php ENDPATH**/ ?>