<?php $__env->startComponent('mail::message'); ?>


管理者あてに <?php echo e($user->name); ?> 様より <br>
以下の閲覧の依頼が投稿されております。<br>
<br>
<br>
閲覧承認される場合には、URLとパスワードを共有してください。<br>
<br>
URL:    <?php echo e($url); ?> <br>
<hr>
<br>
ワンタイムパスワード: <?php echo e('     '.$password); ?> <br>
（有効期限は24時間です）<br>
<br>
アップファイリング　サポート
<br>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/email/otp-mail.blade.php ENDPATH**/ ?>