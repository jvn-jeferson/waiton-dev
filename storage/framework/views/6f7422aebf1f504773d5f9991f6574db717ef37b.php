

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            投稿リスト
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-info">
                                    <th>選択</th>
                                    <th>動画名</th>
                                    <th>動画名</th>
                                    <th>投稿日</th>
                                    <th>閲覧URL</th>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="text-center">
                                            <td><input type="checkbox" name="" id=""></td>
                                            <td><?php echo e($video->name ?? ''); ?></td>
                                            <td>
                                                <center>
                                                    <video
                                                        style="width: 70%; border:2px darkgreen dashed; position: relative; display:flex">
                                                        <source src="<?php echo e($video->video_url); ?>">
                                                    </video>
                                                </center>
                                            </td>
                                            <td style="width: 12%"><?php echo e($video->created_at->format('Y-m-d')); ?></td>
                                            <td style="width:45%;">
                                                <div class="container-fluid">
                                                            <input type="text" id="tocopy"  size="50" class="form-control" style="border:0;" value="<?php echo e(base64_encode($video->video_url)); ?>" disabled>
                                                            <input type="hidden" id="copyUrl" value="<?php echo e($video->video_url); ?>">
                                                    <div class="row align-items-center justify-content-center">

                                                        <button id="copySource" class="btn btn-warning col-3 mx-2"
                                                            onclick="copyVSOURCE('<?php echo e($video->video_url); ?>')">URLコピー</button>
                                                        <button class="btn btn-warning col-3 mx-2" type="button"
                                                            onclick="changeVSOURCE('<?php echo e($video->video_url); ?>')">プレビュー</button>
                                                        <button class="btn btn-danger col-3 mx-2" onclick="deleteVideo(<?php echo e($video->id); ?>)">削除</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr class="text-center w-100">
                                            <td colspan="5" class="w-100">
                                                このクライアントのビデオはまだアップロードされていません。
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    <div class="modal" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Video PREVIEW</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video src="" id="player" class="w-100" style="border: 1px solid #c6c6c6" controls>
                    </video>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
<script>
        $("#myModal").on("hidden.bs.modal",function()
            { $("#player").attr("src","");
        })
        function changeVSOURCE(srcVideo) {
            var video = document.getElementById('player');
            video.setAttribute('src', srcVideo);
            video.load();
            video.play();
            $(".modal").modal('show');
        }

        function copyVSOURCE(data) {
            var data = Base64.encode(data);
            var dummy = document.createElement("input");

            // Add it to the document
            document.body.appendChild(dummy);

            // Set its ID
            dummy.setAttribute("id", "dummy_id");

            // Output the array into it
            document.getElementById("dummy_id").value = data;

            // Select it
            dummy.select();

            // Copy its contents
            document.execCommand("copy");

            // Remove it as its not needed anymore
            document.body.removeChild(dummy);
        }

        function deleteVideo(video_id)
        {
            var url = "<?php echo e(route('delete-video')); ?>"

            Swal.fire({
                icon: 'danger',
                title: '動画を削除しますか？',
                confirmButtonText: 'はい',
                cancelButtonText: 'いいえ',
                showCancelButton: true
            }).then((result) => {
                if(result.isConfirmed)
                {
                    axios.post(url, {
                        id: video_id
                    }).then(function(response) {
                        Swal.fire({
                            title: "動画の削除に成功しました",
                            icon: 'success',
                            showCancelButton: false
                        })

                        window.location.reload()
                    }).catch(function(error) {
                        console.log(error.response.data)
                    })
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/host/individual-clients/video-list.blade.php ENDPATH**/ ?>