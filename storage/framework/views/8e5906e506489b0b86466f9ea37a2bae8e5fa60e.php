

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <form action="<?php echo e(route('save-taxation-history', ['client_id'=>$hashids->encode($client->id)])); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card-header">
                                <h3 class="card-title">過去決算</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <input type="hidden" name="client_id" id="client_id" value="<?php echo e($hashids->encode($client->id)); ?>">
                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo e(Auth::user()->id); ?>">
                                        <?php if($record): ?>
                                        <input type="hidden" name="record_id" id="record_id" value="<?php echo e($record->id); ?>">
                                        <?php endif; ?>
                                        <p><a href="#" onclick="window.open('<?php echo e(route('video-creation', ['client_id'=>$hashids->encode($client->id), 'record_id' => $record->id ?? 0])); ?>');">こちらから動画を作成し. URLを貼り付けてください。</a></p>
                                        <?php
                                        $encrypt_url = isset($record->video_url) ? base64_encode($record->video_url) : null;
                                        ?>
                                        <?php if($record == null): ?>
                                        <input type="text" name="video-url" id="video-url" class="form-control" placeholder="動画のURLを貼り付けてください" value="">
                                        <input type="hidden" name="video_url" id="video_url" value="<?php echo e($record->video_url ?? ''); ?>">
                                        <?php else: ?>
                                        <input type="text" name="video-url" id="video-url" class="form-control" readonly placeholder="動画のURLを貼り付けてください" value="<?php echo e($encrypt_url); ?>">
                                        <?php endif; ?>
                                        <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger">
                                                <?php echo e($message); ?>

                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <video style="width: 100%; border:2px darkgreen dashed; position: relative; display:flex" class="mt-2" id="video-player" controls><source src="<?php if($record): ?><?php echo e($record->video_url); ?><?php endif; ?>"></video>
                                    </div>
                                    <div class="col-5">
                                        <h4 class="text-bold">
                                            必要事項を入力・アップロードしてください。
                                        </h4>
                                        <div class="table-responsive">
                                            <table class="table-bordered table">
                                                <tbody>
                                                    <tr>
                                                        <th>種類</th>
                                                        <td class="bg-light">
                                                                                                                                                                <?php if($record == null): ?>
                                                            <select name="kinds" id="kinds" class="form-control">
                                                                <option value="決算書">決算書</option>
                                                                <option value="届出">届出</option>
                                                                <option value="申請">申請</option>
                                                                <option value="その他">その他</option>
                                                            </select>
                                                            <?php $__errorArgs = ['kinds'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger">
                                                                <?php echo e($message); ?>

                                                            </span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            <?php else: ?>
                                                            <input type="text" name="kinds" id="kinds" class="form-control" readonly value="<?php echo e($record->kinds ?? ''); ?>">
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>提出日</th>
                                                        <td class="bg-light">
                                                            <?php if($record == null): ?>
                                                            <input type="date" class="form-control" name="settlement_date" id="settlement_date" value="<?php echo e($record != null ? $record->settlement_date->format('Y-m-d') : date('Y-m-d')); ?>">
                                                            <?php $__errorArgs = ['settlement_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger">
                                                                <?php echo e($message); ?>

                                                            </span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            <?php else: ?>
                                                            <input type="input" name="settlement_date" id="settlement_date" class="form-control" readonly value="<?php echo e($record->created_at ?? ''); ?>">
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>保管ファイル</th>
                                                        <td class="bg-light">
                                                            <?php if($record == null): ?>
                                                                <input type="file" name="file" id="file" class="form-control" >
                                                                <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="text-danger">
                                                                    <?php echo e($message); ?>

                                                                </span>
                                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                            <?php else: ?>
                                                                <input type="text" name="file" id="file" class="form-control" readonly value="<?php echo e($record->file->name ?? ''); ?>">
                                                            <?php endif; ?>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <th>コメント</th>
                                                        <td class="bg-light">
                                                            <?php if($record == null): ?>
                                                            <textarea rows="5" type="text" name="comment" id="comment" class="form-control" value="<?php echo e($record->comment ?? ''); ?>"></textarea>
                                                            <?php else: ?>
                                                                <textarea rows="5" type="text" name="comment" id="comment" class="form-control"><?php echo e($record->comment); ?></textarea>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card">
                                            <?php if($record == null): ?>
                                            <div class="row p-2">
                                                <div class="col-6">
                                                    <button type="button" onclick="window.open('<?php echo e(route('video-creation', ['client_id'=>$hashids->encode($client->id), 'record_id' => $record->id ?? 0])); ?>');" class="btn btn-warning btn-block">動画作成</button>
                                                </div>
                                                <div class="col-6">
                                                    <button class="btn btn-warning  btn-block" type="button">プレビュー</button>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <?php endif; ?>
                                            <div class="row p-2">
                                                <div class="col-6">
                                                    <button class="btn btn-warning  btn-block" type="submit">登録</button>
                                                </div>
                                                <div class="col-6">
                                                    <button class="btn btn-danger  btn-block" type="button">削除</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
    <script>
        var video_player = document.querySelector('#video-player')
        var src_input = document.querySelector('#video-url')

        $('#video-url').keyup(function() {
            var url = src_input.value;
            var value_url = Base64.decode(url)
            var ci = document.getElementById('video-player')
            var vidSrc = document.getElementById('vidsrc');
            if(isValidHttpUrl(value_url)){
                $('source').attr('src',value_url)
                $("#video_url").val(value_url)
                video_player.load()
            }
            else {
                console.log('ERROR')
            }
        })

        function isValidHttpUrl(string) {
            let url;

            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }

            return url.protocol === "http:" || url.protocol === "https:";
        }



        function openVideoRecorder()
        {
            var target_url = "<?php echo e(route('video-creation', ['client_id'=>$hashids->encode($client->id)])); ?>"
            var kinds = document.querySelector('input#kinds')
            var settlement_date = document.querySelector('input#settlement_date')
            var file = document.querySelector('input#file')
            var recognition_date = document.querySelector('input#recognition_date')
            var proposal_date = document.querySelector('input#proposal_date')
            var company_representative = document.querySelector('input#company_representative')
            var accounting_office_staff = document.querySelector('input#accounting_office_staff')
            var video_contributor = document.querySelector('input#video_contributor')
            var comment = document.querySelector('input#comment')


        }

        $(function() {
            $('form').submit(function(e) {
                Swal.showLoading()
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/host/individual-clients/past-settlement.blade.php ENDPATH**/ ?>