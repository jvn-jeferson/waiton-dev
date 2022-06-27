

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">顧客の情報</h3>
                        <button id="submit_settings" class="btn btn-warning btn-block col-1 float-right" data-toggle="modal" data-target="#changeRegistrationInfoModal">変更</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form class="various_settings">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-gray w-25">社名</th>
                                        <td class="w-50"><input type="text" name="name" id="name" value="<?php echo e($client->name); ?>" class="form-control" readonly/></td>
                                        <td>
                                            <div class="form-inline">
                                                <input type="radio" name="business_type_id" id="business_type_id" value="1" class="mx-auto my-auto" <?php if($client->business_type_id == 1): ?> checked <?php endif; ?> disabled>法人
                                                <input type="radio" name="business_type_id" id="business_type_id" value="2" class="mx-auto my-auto" <?php if($client->business_type_id == 2): ?> checked <?php endif; ?> disabled>個人
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">本店所在地</th>
                                        <td colspan="2"><input type="text" name="address" id="address" value="<?php echo e($client->address); ?>" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">代表者</th>
                                        <td colspan="2"><input type="text" name="representative" id="representative" value="<?php echo e($client->representative); ?>" class="form-control" readonly /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">代表者住所</th>
                                        <td colspan="2"><input type="text" name="representative_address" id="representative_address" value="<?php echo e($client->representative_address); ?>" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">決算月</th>
                                        <td colspan="">
                                            <select name="final_accounts_month" id="final_accounts_month" class="col-2 form-control w-25" disabled>
                                                <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <option value="<?php echo e($month); ?>" <?php echo e($month == $client->tax_filing_month.'月' ? 'selected' : ''); ?>><?php echo e($month); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">消費税の申告義務</th>
                                        <td colspan="2">

                                            <div class="form-row">
                                                <div class="col-12">
                                                    <input type="checkbox" name="data1" id="data1" value="課税事業者" disabled <?php if($client->obligation && $client->obligation->is_taxable): ?> checked <?php endif; ?>>
                                                    <label for="">課税事業者</label>
                                                </div>
                                            </div>

                                            <div class="form-row p-auto">
                                                <div class="ml-3 col-2">
                                                    <input type="checkbox" id="data2" name="data2" value="原則" disabled <?php if($client->obligation && $client->obligation->calculation_method == 1): ?> checked <?php endif; ?>>
                                                    <label for="data2">原則</label>
                                                </div>
                                                <div class="col-2">
                                                    (
                                                    <input type="checkbox" id="data2" name="data2" value="全額控除" disabled <?php if($client->obligation && $client->obligation->taxable_type == 1): ?> checked <?php endif; ?>>
                                                    <label for="data1">全額控除</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="data3" name="data3" value="個別" disabled <?php if($client->obligation && $client->obligation->taxable_type == 2): ?> checked <?php endif; ?>>
                                                    <label for="data1"> 個別</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="data4" name="data4" value="一括" disabled <?php if($client->obligation && $client->obligation->taxable_type == 3): ?> checked <?php endif; ?>>
                                                    <label for="data1"> 一括 )</label>
                                                </div>
                                            </div>
                                            <div class="form-row p-auto">
                                                <div class="ml-3 col-auto">
                                                    <input type="checkbox" class="checkbox" id="data5" value="簡易課税" disabled <?php if($client->obligation && $client->obligation->calculation_method == 0): ?> checked <?php endif; ?>>
                                                    <label for="data5">簡易課税</label>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-12">
                                                    <input type="checkbox" id="data5" name="data5" value="免税事業者" disabled <?php if($client->obligation && $client->obligation->is_taxable == 0): ?> checked <?php endif; ?>>
                                                    <label for="data1"> 免税事業者</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">国税庁識別番号</th>
                                        <td colspan="2"><input type="text" name="nta_num" id="nta_num" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->nta_id ?? ''); ?>" <?php endif; ?> readonly></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">パスワード</th>
                                        <td colspan="2"><input type="text" name="nta_pw" id="nta_pw" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->nta_password ?? ''); ?>" <?php endif; ?> readonly></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">E-tax納税者番号</th>
                                        <td colspan="2"><input type="text" name="el_tax_num" id="el_tax_num" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->el_tax_id ?? ''); ?>" <?php endif; ?> readonly></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">国税庁識別番号</th>
                                        <td colspan="2"><input type="text" name="el_tax_pw" id="el_tax_pw" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->el_tax_password ?? ''); ?>" <?php endif; ?> readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card card-dark card-outline">
                    <form action="<?php echo e(route('new-client-user')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="client_id" id="client_id" value="<?php echo e($client->id); ?>">
                        <div class="card-header">
                            <h3 class="card-title text-dark text-bold">
                                新規登録
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-gray w-25">
                                        <label for="" class="h4">
                                            <input type="radio" name="is_admin" id="is_admin" value="1"> 管理者
                                        </label>
                                    </th>
                                    <td class="w-25 text-center">名前</td>
                                    <td class="bg-gray">
                                        <input type="text" name="staff_name" id="staff_name" class="form-control">
                                        <?php $__errorArgs = ['staff_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-gray w-25">

                                        <label for="" class="h4">
                                            <input type="radio" name="is_admin" id="is_admin" value="0"> 利用者
                                        </label>
                                        <?php $__errorArgs = ['is_admin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </th>
                                    <td class="w-25 text-center">メールアドレス</td>
                                    <td class="bg-gray">
                                        <input type="text" name="staff_email" id="staff_email" class="form-control">
                                        <?php $__errorArgs = ['staff_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary float-right btn-submit" type="submit">登録</button>
                        </div>
                    </form>
                </div>
                <div class="card card-dark card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-bold text-dark">
                            ログイン情報
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center"><button class="btn btn-warning" type="button" data-toggle="modal" data-target="#changeContactEmailModal">変更</button></td>
                                    <td class="w-25">ワンタイムパスワードの • 送付先メールアドレス</td>
                                    <td><?php echo e($client->contact_email); ?></td>
                                </tr>
                                <?php $__empty_1 = true; $__currentLoopData = $client->staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="bg-gray">
                                        <td colspan="3">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <?php if($staff->is_admin == 1): ?>
                                                管理者
                                            <?php else: ?>
                                                利用者
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            ID
                                        </td>
                                        <td>
                                            <?php echo e($staff->user->login_id); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <?php if(Auth::user()->role_id == 2): ?>
                                                <button class="btn btn-warning" role="button" onclick="updateUser(<?php echo e($staff->id); ?>)">変更</button>
                                            <?php endif; ?>
                                        </td>
                                        <th class="">
                                            名前
                                        </th>
                                        <td class="">
                                            <?php echo e($staff->name); ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <?php if(Auth::user()->role_id == 2): ?>
                                                <button class="btn btn-danger" onclick="deleteUser(<?php echo e($staff->id); ?>)">削除</button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            アクセスレベル
                                        </td>
                                        <td>
                                            <?php if($staff->is_admin == 0): ?>
                                            利用者
                                            <?php else: ?>
                                            管理者
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                        </td>
                                        <td>
                                            メールアドレス
                                        </td>
                                        <td>
                                            <?php echo e($staff->user->email); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade " tabindex="-1" role="dialog" id="changeRegistrationInfoModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-bold">
                        顧客の情報
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="tabContent">
                        <li class="nav-item">
                            <a href="#registration_info" data-toggle="tab" class="nav-link active">顧客情報</a>
                        </li>
                        <li class="nav-item">
                            <a href="#checkboxes" data-toggle="tab" class="nav-link">消費税の状態</a>
                        </li>
                        <li class="nav-item">
                            <a href="#taxation_credentials" data-toggle="tab" class="nav-link">電子申告用ID/PW</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="registration_info">
                            <form action="<?php echo e(route('update-client-info')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" id="id" value="<?php echo e($client->id); ?>">
                                <div class="p-3 table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-gray w-25">社名</th>
                                                <td>
                                                    <input type="text" name="name" id="name" class="form-control" value="<?php echo e($client->name); ?>">
                                                </td>
                                                <td class="text-center">
                                                    <div class="form-inline">
                                                        <input type="radio" name="business_type_id" id="business_type_id" value="1" class="mx-auto my-auto" <?php if($client->business_type_id == 1): ?> checked <?php endif; ?>>法人
                                                        <input type="radio" name="business_type_id" id="business_type_id" value="2" class="mx-auto my-auto" <?php if($client->business_type_id == 2): ?> checked <?php endif; ?>>個人
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">本店所在地</th>
                                                <td colspan="2">
                                                    <input type="text" name="address" id="address" class="form-control" value="<?php echo e($client->address); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">代表者</th>
                                                <td colspan="2">
                                                    <input type="text" name="representative" id="representative" class="form-control" value="<?php echo e($client->representative); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">代表者住所</th>
                                                <td colspan="2">
                                                    <input type="text" name="representative_address" id="representative_address" class="form-control" value="<?php echo e($client->representative_address ?? ''); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">決算月</th>
                                                <td colspan="2">
                                                    <select name="tax_filing_month" id="tax_filing_month" class="form-control">
                                                        <option value="1" <?php if($client->tax_filing_month == 1): ?> selected <?php endif; ?>>1月</option>
                                                        <option value="2" <?php if($client->tax_filing_month == 2): ?> selected <?php endif; ?>>2月</option>
                                                        <option value="3" <?php if($client->tax_filing_month == 3): ?> selected <?php endif; ?>>3月</option>
                                                        <option value="4" <?php if($client->tax_filing_month == 4): ?> selected <?php endif; ?>>4月</option>
                                                        <option value="5" <?php if($client->tax_filing_month == 5): ?> selected <?php endif; ?>>5月</option>
                                                        <option value="6" <?php if($client->tax_filing_month == 6): ?> selected <?php endif; ?>>6月</option>
                                                        <option value="7" <?php if($client->tax_filing_month == 7): ?> selected <?php endif; ?>>7月</option>
                                                        <option value="8" <?php if($client->tax_filing_month == 8): ?> selected <?php endif; ?>>8月</option>
                                                        <option value="9" <?php if($client->tax_filing_month == 9): ?> selected <?php endif; ?>>9月</option>
                                                        <option value="10" <?php if($client->tax_filing_month == 10): ?> selected <?php endif; ?>>10月</option>
                                                        <option value="11" <?php if($client->tax_filing_month == 11): ?> selected <?php endif; ?>>11月</option>
                                                        <option value="12" <?php if($client->tax_filing_month == 12): ?> selected <?php endif; ?>>12月</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-warning float-right">変更</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="checkboxes">
                            <form action="<?php echo e(route('update-client-obligation')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" id="id" value="<?php echo e($client->id); ?>">
                                <div class="p-3 table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-gray w-25">消費税の申告義務</th>
                                                <td class="text-center">
                                                    <div class="form-inline">
                                                        <input type="radio" name="is_taxable" id="is_taxable" value="1" class="mx-2" <?php if($client->obligation && $client->obligation->is_taxable == 1): ?> checked <?php endif; ?>>課税事業者
                                                        <input type="radio" name="is_taxable" id="is_taxable" value="0" class="mx-2" <?php if($client->obligation && $client->obligation->is_taxable == 0): ?> checked <?php endif; ?>>免税事業者
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">計算方法</th>
                                                <td class="text-center">
                                                    <div class="form-inline">
                                                        <input type="radio" name="calculation_method" id="calculation_method" value="1" class="mx-2" <?php if($client->obligation && $client->obligation->calculation_method == 1): ?> checked <?php endif; ?>>
                                                            原則課税
                                                        <input type="radio" name="calculation_method" id="calculation_method" value="0" class="mx-2" <?php if($client->obligation && $client->obligation->calculation_method == 0): ?> checked <?php endif; ?>>
                                                        簡易課税
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">原則課税時の計算方法</th>
                                                <td class="text-center">

                                                    <div class="form-inline">
                                                        <input type="radio" name="taxable_type" id="taxable_type" value="1" class="mx-2" <?php if($client->obligation && $client->obligation->taxable_type == 1): ?> checked <?php endif; ?>>
                                                        全額控除
                                                        <input type="radio" name="taxable_type" id="taxable_type" value="2" class="mx-2" <?php if($client->obligation && $client->obligation->taxable_type == 2): ?> checked <?php endif; ?>>
                                                        個別
                                                        <input type="radio" name="taxable_type" id="taxable_type" value="3" class="mx-2" <?php if($client->obligation && $client->obligation->taxable_type == 3): ?> checked <?php endif; ?>>
                                                        一括
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-warning float-right">変更</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="taxation_credentials">
                            <form action="<?php echo e(route('update-client-credentials')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" id="id" value="<?php echo e($client->id); ?>">
                                <div class="p-3 table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-gray w-25">国税庁識別番号</th>
                                                <td>
                                                    <input type="text" name="nta_num" id="nta_num" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->nta_id ?? ''); ?>" <?php endif; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">パスワード（国税用）</th>
                                                <td>
                                                    <input type="text" name="nta_password" id="nta_password" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->nta_password ?? ''); ?>" <?php endif; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">EL-tax納税者番号</th>
                                                <td>
                                                    <input type="text" name="el_tax_num" id="el_tax_num" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->el_tax_id ?? ''); ?>" <?php endif; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">パスワード（地方税用）</th>
                                                <td>
                                                    <input type="text" name="el_tax_password" id="el_tax_password" class="form-control" <?php if($client->credentials): ?> value="<?php echo e($client->credentials->el_tax_password ?? ''); ?>" <?php endif; ?>>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-warning float-right">変更</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="changeContactEmailModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-bold">
                        送付先メールアドレス
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('change-contact-email')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="client_id" id="client_id" value="<?php echo e($client->id); ?>" />
                        <div class="table-responsive">
                            <table class="table-bordered table">
                                <tr>
                                    <th>Email</th>
                                    <td class="bg-dark">
                                        <input type="email" name="contact_email" id="contact_email" value="<?php echo e($client->contact_email); ?>" class="form-control">
                                    </td>
                                    <td><button type="submit" class="btn btn-success btn-block">編集</button></td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal face" id="userModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Update User Information
                    </h4>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <form method="post" action="<?php echo e(route('update-client-staff')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="userID" id="userID">
                    <input type="hidden" name="clientID" id="clientID" value="<?php echo e($client->id); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>
                                            名前
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" id="userName" name="userName">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            メールアドレス
                                        </th>
                                        <td>
                                            <input type="email" class="form-control" id="userEmail" name="userEmail">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            ユーザーID
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" id="userLogin" name="userLogin" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="float-right btn btn-primary" type="submit">変更</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra-scripts'); ?>

    <script>
        function deleteUser(id)
        {
            Swal.fire({
                title: "本当に削除しますか？",
                confirmButtonText: 'はい',
                cancelButtonText: "いいえ",
                showCancelButton: true,
                focusConfirm: false
            }).then((result) => {
                if(result.isConfirmed) {
                    Swal.showLoading()
                    var url = "<?php echo e(route('delete-user')); ?>"
                    axios.post(url, {
                        user_id : id
                    }).then(function(response) {
                        if(response.data == 'Deleted!')
                        {
                            Swal.fire({
                                title: '削除完了しました。',
                                icon: 'success'
                            }).then((result) => {
                                if(result.isConfirmed)
                                {
                                    location.reload()
                                }
                            })
                        }
                    }).catch(function(error) {
                        console.log(error.response.data)
                    })
                }
            })
        }

        function updateUser(user_id)
        {
            var url = "<?php echo e(route('get-client-staff')); ?>"
            var userModal = $('#userModal');
            axios.post(url, {
                id: user_id,
            }).then(function(response) {
                name = response.data['name']
                email = response.data['email']
                id = response.data['id']
                login_id = response.data['login_id']
                remember_token = response.data['token']

                $('#userName').val(name)
                $('#userEmail').val(email)
                $('#userLogin').val(login_id)
                $('#userID').val(id)
                userModal.modal('show');

            }).catch(function(error) {
                console.log(error.response.data)
            })
        }

        $(function() {
            $('form').submit(function(e) {
                Swal.showLoading()
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.host-individual', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\waiton-dev\resources\views/host/individual-clients/view-registration-info.blade.php ENDPATH**/ ?>