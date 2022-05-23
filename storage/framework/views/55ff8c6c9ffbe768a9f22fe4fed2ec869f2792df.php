<?php $__env->startComponent('mail::message'); ?>
# <?php echo e($host->name); ?> よりファイルが投稿されております。

<h3 class="text-warning"><i class="fa fa-warning"></i> 【注意】</h3>
こちらのファイルは、承認または保留の対応が必要ですので、<br>
以下のＵＲＬからログインして確認をお願いします。<br>
https://upfiling.jp/ <br>
<br>
<br>
アップファイリング　サポート
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/email/approval-required-mail.blade.php ENDPATH**/ ?>