<?php $__env->startComponent('mail::message'); ?>

User with the login ID : <?php echo e('     '.$login_id); ?> has been deleted from Upfiling.jp records.
<br>
<br>
<hr>
このメールは送信専用です。<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。<br>
アップファイリング　https://upfiling.jp/
<hr>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/email/deleted-user-mail.blade.php ENDPATH**/ ?>