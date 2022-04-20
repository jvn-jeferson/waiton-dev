

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        経理部から受け取ったデータ（閲覧期限1ヶ月）
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        以下のファイルが会計事務所から送信されました。承認が必要な資料については、承認/予約を確認して選択し、処理を決定してください。  （視聴期限は1ヶ月です)
                    </p>
                    <?php $__empty_1 = true; $__currentLoopData = $host_uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $host_upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <table style="table-layout:fixed; width:100%" class="table table-bordered table-outline text-center my-2">
                            <thead class="thead-dark">
                                <th>投稿情報</th>
                                <th>締め切りの表示</th>
                                <th>ドキュメントのタイトル</th>
                                <th>オプション</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="w-25" rowspan="2">
                                        <p class="text-dark">
                                            <?php echo e($host_upload->created_at->format('Y年m月d日 H:i')); ?>

                                        </p>
                                    </td>
                                    <td class="w-25" rowspan="2">
                                        <p class="text-dark">
                                            <?php echo e($host_upload->created_at->modify('+1 month')->format('Y年m月d日 H:i')); ?>

                                        </p>
                                    </td>
                                    <td class="text-info w-25" rowspan="2">
                                        <?php if($host_upload->file): ?>
                                            <a href="#" onclick="updateStatus(<?php echo e($host_upload->id); ?>, this)" role="button"><?php echo e($host_upload->file->name); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td
                                        class="text-center w-25
                                    <?php switch($host_upload->status):
                                        case (1): ?>
                                            bg-light
                                            <?php break; ?>
                                        <?php case (2): ?>
                                            bg-success
                                            <?php break; ?>
                                        <?php case (3): ?>
                                            bg-light
                                            <?php break; ?>
                                        <?php case (4): ?>
                                            bg-dark
                                            <?php break; ?>
                                        <?php default: ?>
                                            bg-light
                                            <?php break; ?> <?php endswitch; ?>
                                ">
                                        <?php if($host_upload->priority == 0): ?>
                                            承認
                                        <?php else: ?>
                                            ---
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="text-center
                                    <?php switch($host_upload->status):
                                        case (1): ?>
                                            bg-light
                                            <?php break; ?>
                                        <?php case (2): ?>
                                            bg-light
                                            <?php break; ?>
                                        <?php case (3): ?>
                                            bg-danger
                                            <?php break; ?>
                                        <?php case (4): ?>
                                            bg-dark
                                            <?php break; ?>
                                        <?php default: ?>
                                            bg-light
                                            <?php break; ?> <?php endswitch; ?>
                                ">
                                        <?php if($host_upload->priority == 0): ?>
                                            保留
                                        <?php else: ?>
                                            ---
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light w-25">
                                        コメント
                                    </td>
                                    <td colspan="2" class="w-50">
                                        <?php echo e($host_upload->details); ?>

                                    </td>
                                    <td class="bg-primary" class="w-25">
                                        <?php if($host_upload->priority == 0): ?>
                                        <button class="btn btn-flat btn-block btn-primary" role="button"
                                            onclick="admitFile(<?php echo e($host_upload->id); ?>)">
                                            確認が必要
                                        </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light w-25">
                                        URL
                                    </td>
                                    <td colspan="2" style="overflow:hidden; width:50px;">
                                        <a href="#"
                                            onclick="decrypt_video('<?php echo e($host_upload->video_url); ?>')"><?php echo e($host_upload->video_url); ?></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
    <script>
        function decrypt_video(value) {
            var data = Base64.decode(value);
            if (isUrl(data)) {
                var valid_url = data
            } else {
                var valid_url = value
            }
            let a = document.createElement('a');
            a.target = '_blank';
            a.href = valid_url;
            a.click();
        }

        function isUrl(s) {
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
            return regexp.test(s);
        }


        function admitFile(post_id)
        {

            var url = "<?php echo e(route('admit-host-upload')); ?>"

            Swal.fire({
                icon: 'question',
                title: '資料について承認・保留を決定してください',
                confirmButtonText: '承認',
                denyButtonText: '保留',
                cancelButtonText: 'キャンセル',
                showDenyButton: true,
                showCancelButton: true
            }).then((result) => {
                var status = 0;

                if(result.isConfirmed) {
                    Swal.fire({
                        title: "承認しますか？",
                        icon: 'question',
                        confirmButtonText: 'はい',
                        cancelButtonText: 'いいえ',
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        preConfirm: function() {
                            return axios.post(url, {
                                id: post_id,
                                status: 2
                            }).then(function(response) {
                                window.location.reload()
                            }).catch(function(error) {
                                console.log(error.response.data)
                                return false;
                            })
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    })
                }else if(result.isDenied){
                    Swal.fire({
                        title: "保留しますか？",
                        icon: 'warning',
                        confirmButtonText: 'はい',
                        cancelButtonText: 'いいえ',
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            return axios.post(url, {
                                id: post_id,
                                status: 3
                            }).then(function (response) {
                                window.location.reload()
                            }).catch(function (error) {
                                console.log(error.response.data)
                                return false
                            })
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    })
                }
            })
        }

        function updateStatus(post_id)
        {
            Swal.showLoading()
            var url = "<?php echo e(route('download-host-file')); ?>"

            axios.post(url, {
                record_id: post_id
            }).then(function(response) {
                if(Swal.isLoading())
                {
                    Swal.hideLoading()
                }
                const link = document.createElement('a')
                link.href = "https://storage.googleapis.com/upfiling_bukcet/"+response.data[0]
                link.setAttribute('download', response.data[1]);
                link.click();
                document.removeChild(link);
                button.disabled = 'disabled'
            }).catch(function(error) {
                console.log(error.response);
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/client/incoming.blade.php ENDPATH**/ ?>