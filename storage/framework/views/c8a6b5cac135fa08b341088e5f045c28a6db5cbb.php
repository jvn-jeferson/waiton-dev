
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center p-0">
            <div class="col-lg-12">
                <div class="row">
                    <video src="" id="player" width="100%" height="600" controls style="border: 1px solid #c6c6c6; background: lightblue" autoplay>
                    </video>
                    <input type="hidden" name="video_player" id="video_player" value="<?php echo e($record->video_url); ?>">
                </div>
                <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <th class="text-center">種類</th>
                                    <th><?php echo e($record->kinds); ?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">投稿日</td>
                                        <td><?php echo e($record->created_at->format('Y年m月d日')); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">保管資料</td>
                                        <td>
                                            <?php echo e($record->file->name); ?> <br>
                                            <a class="btn btn-block btn-warning" type="button" href="#" onclick="downloadFile(<?php echo e($record->file->id); ?>, this)">ダウンロード</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">投稿者</td>
                                        <td><?php echo e($record->accounting_office_staff); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">コメント</td>
                                        <td><?php echo nl2br($record->comment); ?></td>
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

        function downloadFile(id, button)
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/client/view_archived_taxation.blade.php ENDPATH**/ ?>