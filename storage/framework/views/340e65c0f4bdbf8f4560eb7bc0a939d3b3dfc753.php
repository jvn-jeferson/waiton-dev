

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">

        <!-- Main Content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title text-bold">
                      連絡事項
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <ul class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <li class="list-group-item">
                            <i class="fas fa-circle <?php if($message->is_global == 0): ?> text-success <?php else: ?> text-primary <?php endif; ?>"></i>
                            <strong class="<?php if($message->is_global == 0): ?> text-success <?php else: ?> text-primary <?php endif; ?>">
                              <?php if($message->scheduled_at): ?>
                              <?php echo e($message->scheduled_at->format('Y年m月d日')); ?>

                              <?php else: ?>
                              <?php echo e($message->created_at->format('Y年m月d日')); ?>

                              <?php endif; ?>
                            </strong>
                            - <?php echo nl2br($message->contents); ?> <?php if($message->file): ?> <a href="#" onclick="downloadFile(<?php echo e($message->file->id); ?>, this)"><i class="fa fas fa-paperclip"></i></a> <?php endif; ?>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                          <li class="text-info list-group-item">
                            新しい通知はありません.
                          </li>
                        <?php endif; ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title text-bold">
                      To会計事務所
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                          <tr>
                            <th>郵送日</th>
                            <th>ファイル名</th>
                            <th>状態</th>
                            <th>閲覧期限</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $__empty_1 = true; $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                              <td><?php echo e($upload->created_at->format('Y年m月d日')); ?></td>
                              <td class="text-info"><a href="#" onclick="downloadFile(<?php echo e($upload->file->id); ?>, this)"><?php echo e($upload->file->name); ?></a></td>
                              <td>アップロード</td>
                              <td><?php echo e($upload->created_at->modify('+1 month')->format('Y年m月d日')); ?></td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                              <td colspan="4">データなし</td>
                            </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title text-bold">
                      From会計事務所
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                          <th>郵送日</th>
                          <th>ファイル名</th>
                          <th>状態</th>
                          <th>確認リクエスト</th>
                          <th>視聴期限</th>
                        </thead>
                        <tbody>
                          <?php $__empty_1 = true; $__currentLoopData = $downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                              <td><?php echo e($download->created_at->format('Y年m月d日')); ?></td>
                              <td class="text-info">
                                <?php if($download->file): ?>
                                <a href="#" onclick="downloadFile(<?php echo e($download->file->id); ?>, this)"><?php echo e($download->file->name ?? ''); ?></a>
                                <?php endif; ?>
                              </td>
                              <td>
                                <?php switch($download->status):
                                  case (0): ?>
                                    ファイル名
                                    <?php break; ?>
                                  <?php case (2): ?>
                                    承認
                                    <?php break; ?>
                                  <?php case (3): ?>
                                    保留
                                    <?php break; ?>
                                  <?php default: ?>

                                    <?php break; ?>
                                <?php endswitch; ?>
                              </td>
                              <td><?php if($download->priority == 0): ?> （確認依頼あり）<?php endif; ?></td>
                              <td><?php echo e($download->created_at->modify('+1 month')->format('Y年m月d日')); ?></td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                              <td colspan="5" class="text-center">データなし</td>
                            </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card card-danger card-outline">
                  <div class="card-header">
                    <h3 class="card-title text-bold">
                      資料の保管
                    </h3>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover">
                        <thead class="bg-info">
                          <th>アップロード日</th>
                          <th>ファイル名</th>
                          <th>ストレージステータス</th>
                        </thead>
                        <tbody>
                          <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                              <td><?php echo e($file->created_at->format('Y年m月d日')); ?></td>
                              <td class="text-info"><a href="#" onclick="downloadFile(<?php echo e($file->id); ?>, this)"><?php echo e($file->name); ?></a></td>
                              <td>
                                <?php if($file->deleted_at): ?>
                                  アーカイブされました。
                                <?php else: ?>
                                  が保存されました。
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                              <td colspan="3" class="text-center text-info">
                                まだファイルをアップロードしていません。
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



<?php echo $__env->make('layouts.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/client/dashboard.blade.php ENDPATH**/ ?>