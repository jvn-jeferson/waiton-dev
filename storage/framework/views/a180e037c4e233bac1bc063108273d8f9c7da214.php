<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($staff->name); ?>　様より問い合わせありました。
<br>
<hr>
<span class="text-bold">所属：</span><?php echo e($affiliation->name); ?>

<br>
<span class="text-bold">所属：</span><?php echo e($user->email); ?>

<br>
<br>
<hr>
問合わせ内容
<br>
<?php echo nl2br($content); ?>

<hr>
<br>
このメールは送信専用です。
直接メールアドレスに返答してください。
<?php echo $__env->renderComponent(); ?><?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/email/inquiry-mail.blade.php ENDPATH**/ ?>