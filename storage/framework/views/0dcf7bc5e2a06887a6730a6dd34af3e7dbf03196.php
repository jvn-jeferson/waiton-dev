<?php $__env->startComponent('mail::message'); ?>

<h4>
    <?php echo e($name); ?>

</h4>

<?php echo e($accountingOffice->name); ?> 様からのご招待メール <br>
<?php echo e($accountingOffice->name); ?> とクライアントの情報プラットフォーム <br>
UpFiling.jpをご利用いただきありがとうございます。<br>
<br>
<?php echo e($accountingOffice->name); ?>　様よりご招待メールが発行されました。<br>

<br>
以下のURLからアクセスしていただき、UpFiling.jpのユーザーログイン情報を設定してください。
<br>

<a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>

<h4>
    ログインID： <strong><?php echo e('     '.$user->login_id); ?></strong>
</h4>
<h4>
    初期パスワード： <strong><?php echo e('     '.$password); ?></strong>
</h4>
<br>
<h6>
    （ログイン時にパスワードの設定をお願いしております）
</h6>

<hr>
このメールは送信専用です。
<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。
<br>
アップファイリング　https://upfiling.jp/
<hr>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/email/new-client-user-email.blade.php ENDPATH**/ ?>