<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($client->name); ?> - <?php echo e($staff->name); ?> 様により、承認等の決定処理が完了しました。
<br>
承認等確認書を確認資料アーカイブスに保管しました。<br>
<br>
決定内容は、以下のＵＲＬからログインして確認をお願いします。<br>
https://upfiling.jp/ <br>
<br>
<br>
アップファイリング　サポート
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/email/decision-complete-mail.blade.php ENDPATH**/ ?>