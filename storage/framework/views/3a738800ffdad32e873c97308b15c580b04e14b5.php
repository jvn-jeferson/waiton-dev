<?php $__env->startSection('extra-css'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Main Wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <section class="content">
            <!-- Upload Files -->
            <form action="upload-files" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-success">
                            会計事務所（閲覧期限1ヶ月)
                        </h3>

                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            次のファイルを経理部にアップロードします。アップロード資料にファイルをドロップするか、アップロードボタンからファイルを選択します。
                        </p>
                        <?php if(Session::has('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><?php echo e(Session::get('success')); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <?php if(Session::has('failure')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><?php echo e(Session::get('failure')); ?></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <table class="table table-hover table-bordered table-striped" id="uploadFormTable">
                            <thead class="thead bg-dark">
                                <th>アップロードされた資料</th>
                                <th>備考</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <label for="file" class="btn btn-warning col-2">アップロード</label>
                                            <input type="file" name="file[]" id="file" class="form-control col-10" style="" onchange="showFileName(this, 1)">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="comment[]" id="comment" rows="3" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <label for="file" class="btn btn-warning col-2">アップロード</label>
                                            <input type="file" name="file[]" id="file" class="form-control col-10" style="" onchange="showFileName(this, 2)">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="comment[]" id="comment" rows="3" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <label for="file" class="btn btn-warning col-2">アップロード</label>
                                            <input type="file" name="file[]" id="file" class="form-control col-10" style="" onchange="showFileName(this, 3)">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="comment[]" id="comment" rows="3" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <label for="file" class="btn btn-warning col-2">アップロード</label>
                                            <input type="file" name="file[]" id="file" class="form-control col-10" style="" onchange="showFileName(this, 4)">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="comment[]" id="comment" rows="3" class="form-control"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-row">
                                            <label for="file" class="btn btn-warning col-2">アップロード</label>
                                            <input type="file" name="file[]" id="file" class="form-control col-10" style="" onchange="showFileName(this, 5)">
                                        </div>
                                    </td>
                                    <td>
                                        <textarea name="comment[]" id="comment" rows="3" class="form-control"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <input class="float-right btn btn-success" type="submit" value="アップロード" id="submitBtn" name="submit">
                    </div>
                </form>
            </div>
            <!-- /upload files -->

            <!-- Upload List -->
            <div class="card card-warning card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-dark">
                        アップロードされたファイル
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <button class="float-left btn btn-primary col-3 my-2" type="button" onclick="deletefiles()">選択したファイルを削除</button>
                    <div class="mt-2">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark text-center">
                                <th>撰ぶ</th>
                                <th>投稿日</th>
                                <th>締め切りの表示</th>
                                <th>寄稿者</th>
                                <th>ファイル名</th>
                                <th>備考</th>
                            </thead>
                            <tbody class="text-center">
                                <?php $__empty_1 = true; $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><input type="checkbox" name="file_id" id="file_id" value="<?php echo e($upload->id); ?>"></td>
                                        <td><?php echo e($upload->created_at->format('Y年m月d日 H:i')); ?></td>
                                        <td><?php echo e($upload->created_at->modify('+1 month')->format('Y年m月d日 H:i')); ?></td>
                                        <td><?php echo e($upload->user->clientStaff->name); ?></td>
                                        <td>
                                            <?php if($upload->file): ?>
                                            <a href="#" onclick="downloadFile(<?php echo e($upload->file->id); ?>, this)"><?php echo e($upload->file->name); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($upload->comment); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6">表示するレコードはありません。</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /upload list -->
        </section>
        <!-- End Content -->
    </div>
    <!-- end Main Wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
<script>
    function deletefiles() {

        var checkedBox = document.getElementsByName('file_id')
        const ids = [];
        for (var checkbox of checkedBox) {
            if(checkbox.checked)
            {
                ids.push(checkbox.value);
            }
        }

        //axios here
        var url = "<?php echo e(route('delete-records')); ?>";

        axios.post(url, {
            file_ids: ids
        }).then(function(response) {
            console.log(response.data);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.data
            }).then((result)=>{
                if(result.isConfirmed)
                {
                    window.location.reload();
                }
            })
        }).catch(function(error) {
            console.log(error.response.data);
        })
    }

    function showFileName(input, index)
    {
        //TODO show file_name
        var fileName = input.files[0].name
    }

    $(function() {
        $('form').submit(function(e) {
            Swal.showLoading()
        })
    })

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

<?php echo $__env->make('layouts.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/client/outgoing.blade.php ENDPATH**/ ?>