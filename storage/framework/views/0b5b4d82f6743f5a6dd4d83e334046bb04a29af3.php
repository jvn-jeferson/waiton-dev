    <?php $__env->startComponent('mail::message'); ?>
    会計事務所とクライアントの情報プラットフォーム <br>
    UpFiling.jpをご利用いただきありがとうございます。<br>
    <br>
    <?php echo e($accounting_office->name); ?> 様よりご招待メールが発行されました。<br>
    <br>
    以下のURLからアクセスしていただき、UpFiling.jpのログイン情報を設定してください。<br>
    <br>
    <a href="<?php echo e($url); ?>"><?php echo e($url); ?></a>
    <br>
    <br>
    <h4>
    管理者ログインID: <?php echo e('     '.$user->login_id); ?>

    </h4>
    <h4>
    初期パスワード: <?php echo e('     '.$password); ?>

    </h4>
    （ログイン時にパスワードの設定をお願いしております）
    <br>
    <br>
    <hr>
    このメールは送信専用です。<br>
    ご不明点等は、当行WEBサイトよりお問い合わせください。<br>
    アップファイリング　https://upfiling.jp/
    <hr>

    <?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\laragon\www\waiton-dev\resources\views/email/client-registration-success-mail.blade.php ENDPATH**/ ?>