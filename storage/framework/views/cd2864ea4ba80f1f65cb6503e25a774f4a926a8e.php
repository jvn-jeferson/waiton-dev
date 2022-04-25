

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto col-md-12 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">登録顧客の一覧</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped text-center">
                                    <thead class="thead bg-info">
                                        <tr>
                                            <th>選択 <br> <input type="checkbox" name="all" id="all" value="0"> </th>
                                            <th>事業者名</th>
                                            <th>種類</th>
                                            <th>決算月</th>
                                            <th>国税識別番号 <br> ID/PW</th>
                                            <th>EL-Tax <br> ID/PW</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td rowspan="2"><input type="checkbox" name="select" id="select" value="<?php echo e($client->id); ?>"></td>
                                            <td rowspan="2"><?php echo e($client->name); ?></td>
                                            <td rowspan="2"><?php if($client->business_type_id == 1): ?> 個人 <?php else: ?> 法人 <?php endif; ?></td>
                                            <td rowspan="2"><?php echo e($client->tax_filing_month); ?>月</td>
                                            <td>*********</td>
                                            <td>*********</td>
                                        </tr>
                                        <tr>
                                            <td>*********</td>
                                            <td>*********</td>
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
                        <div class="card-footer">
                            <button class="btn btn-warning float-left text-light" id="downloadBtn">選択データのダウンロード</button>
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
    var select_all = document.querySelector('#all')
    var selects = document.getElementsByName('select')

    select_all.addEventListener('change', function() {
        if (select_all.checked) {
            $.each(selects, function(index, value) {
                selects[index].checked = true
            })
        } else {
            $.each(selects, function(index, value) {
                selects[index].checked = false
            })
        }
    })

    var download = document.querySelector('#downloadBtn')

    download.addEventListener('click', function() {

        var client_id = $('input#select:checked').map(function() {
            return this.value
        }).get()
        var url = "<?php echo e(route('download-client')); ?>";

        axios.post(url, {
            client_id: client_id
        }).then(function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Congrats'
            })

            function download_files(files) {
                function download_next(i) {
                    if (i >= files.length) {
                        return;
                    }
                    var a = document.createElement('a');
                    a.href = files[i].file_url;
                    a.target = '_blank';

                    if ('download' in a) {
                        a.download = files[i].file_name;
                    }

                    (document.body || document.documentElement).appendChild(a);
                    if (a.click) {
                        a.click(); // The click method is supported by most browsers.
                    } else {
                        window.open(files[i].file_url);
                    }
                    a.parentNode.removeChild(a);
                    setTimeout(function() {
                        download_next(i + 1);
                    }, 500);
                }
                // Initiate the first download.
                download_next(0);
            }

            function do_dl() {
            var data = response.data;
                download_files(data);
            };
            do_dl();
        }).catch(function(error) {
            console.log(error.response.data);
        })



        //loop through each checked value
        //for each key:value create a zip file
        //initiate download process
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/host/client-list.blade.php ENDPATH**/ ?>