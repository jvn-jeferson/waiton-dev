

<?php $__env->startSection('content'); ?>
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-cog"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Current Plan</span>
                <span class="info-box-number">
                  <?php if(Auth::user()->accountingOffice->subscription): ?>
                  <?php echo e(Auth::user()->accountingOffice->subscription->subscription_plan->name); ?>

                  <?php else: ?>
                    FREE USER
                  <?php endif; ?>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-hdd"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Storage Usage</span>
                <span class="info-box-number">
                  10 <small>%</small>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-users"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Clients</span>
                <span class="info-box-number">
                  <?php echo e(Auth::user()->accountingOffice->clients->count()); ?> / <?php if(Auth::user()->accountingOffice->subscription): ?> <?php echo e(Auth::user()->accountingOffice->subscription->subscription_plan->max_clients); ?> <?php else: ?> 1 <?php endif; ?>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-tasks"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Tasks</span>
                <span class="info-box-number">
                  10 <small>%</small>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 col-sm-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title text-white">
                  今月の決算
                </h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table-hover table table-striped table-bordered text-center">
                    <thead class="thead bg-info">
                      <th>事業者名</th>
                      <th>決算月</th>
                      <th>提出月</th>
                      <th>種類</th>
                    </thead>
                    <tbody>
                      

                      <?php $__empty_1 = true; $__currentLoopData = Auth::user()->accountingOffice->clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($client->tax_filing_month == date('m')): ?>
                          <tr>
                            <td><?php echo e($client->name); ?></td>
                            <td><?php echo e($client->tax_filing_month.'月'); ?></td>
                            <td></td>
                            <td><?php if($client->business_type_id == 1): ?> 個人 <?php else: ?> 法人 <?php endif; ?></td>
                          </tr>
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                          <td colspan="4" class="text-primary">
                            あなたのオフィスには登録済みのクライアントがありません。
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
        <div class="row">
          <div class="col-12 col-md-12 col-sm-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">事業者情報</h3>
              </div>
              <div class="card-body">
                <table class="table-bordered table">
                  <tbody>
                    <tr>
                      <td class="w-25 text-bold">事務所名</td>
                      <td class="w-75"><?php echo e(Auth::user()->accountingOffice->name ?? ''); ?></td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">所在地</td>
                      <td class="w-75"><?php echo e(Auth::user()->accountingOffice->address ?? ''); ?></td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">代表者
                      </td>
                      <td class="w-75"><?php echo e(Auth::user()->accountingOffice->representative ?? ''); ?></td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">ご利用スタッフ
                      </td>
                      <td class="w-75"><?php if(Auth::user()->accountingOffice->subscription): ?> <?php echo e(Auth::user()->accountingOffice->subscription->status ?? ''); ?> <?php else: ?> FREE USER <?php endif; ?></td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">ご利用期日
                      </td>
                      <td class="w-75"><?php echo e(date_format(Auth::user()->accountingOffice->created_at, 'j F Y') ?? ''); ?></td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">利用メンバー数
                      </td>
                      <td class="w-75"><?php echo e(Auth::user()->accountingOffice->staff->count()); ?>名
                      </td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">登録顧客数
                      </td>
                      <td class="w-75"><?php echo e(Auth::user()->accountingOffice->clients->count()); ?>社</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/host/dashboard.blade.php ENDPATH**/ ?>