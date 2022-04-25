<?php $__env->startComponent('mail::message'); ?>
会計事務所とクライアントの情報プラットフォーム <br>
UpFiling.jpをご利用いただきありがとうございます。<br>
<br>
<?php echo e($accountingOffice->name); ?>　様よりご招待メールが発行されました。<br>
<br>
以下のURLからアクセスしていただき、UpFiling.jpのログイン情報を設定してください。<br>
<br>
<a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
<br>
<br>
<h4>
管理者ログインID：<?php echo e($user->login_id); ?>

</h4>
<h4>
初期パスワード： <?php echo e($password); ?>

</h4>
（ログイン時にパスワードの設定をお願いしております）

<br>
<hr>
このメールは送信専用です。<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。<br>
アップファイリング　https://upfiling.jp/
<hr>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\waiton-dev\resources\views/email/registration-success-mail.blade.php ENDPATH**/ ?>