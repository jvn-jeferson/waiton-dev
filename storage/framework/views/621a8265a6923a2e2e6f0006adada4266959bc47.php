<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="<?php echo e(asset('toppage_data/favicon.ico')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('toppage_data/apple-touch-icon.png')); ?>">
    <title><?php echo e($title); ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-WV7L6QS');
    </script>
    <style type="text/css">
        @font-face {
            font-family: 'CyberCJK';
            font-style: normal;
            font-weight: normal;
            src: url("http://eclecticgeek.com/dompdf/fonts/cjk/Cybercjk.ttf") format("truetype");
        }

        * {
            font-family: 'CyberCJK';
        }

        @page  {
            margin: 0px;
        }

        body {
            margin: 0px;
        }

        html {
            font-size: 14px/1;
            font-family: 'CyberCJK', sans-serif;
            overflow: auto;
        }

    </style>
</head>

<body>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WV7L6QS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <div class="container-fluid p-2">
        <div class="card" id="review_data">
            <div class="card-header justify-content-center align-items-center text-center">
                <h4 class="text-bold">
                    <?php echo e('From会計事務所データの承認等確認書'); ?>

                </h4>
                <h6>
                    <?php echo e('以下のデータについてのやりとりは以下の通り決定されています。'); ?>

                </h6>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table table-bordered my-2">
                        <tbody>
                            <tr>
                                <th style="width:25%">クライアント名</th>
                                <td style="width:75%">
                                    <?php echo e($client_name); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">会計事務所名</th>
                                <td style="width:75%">
                                    <?php echo e($accounting_office_name); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">決定メール送付日</th>
                                <td style="width:75%">
                                    <?php echo e($email_date); ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered my-2 table-condensed">
                        <thead class="bg-dark">
                            <th colspan="2">会計事務所処理</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:25%">送信ファイル名</th>
                                <td style="width:75%">
                                    <?php echo e($file_name); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">送信日</th>
                                <td style="width:75%">
                                    <?php echo e($upload_date); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">送信者</th>
                                <td style="width:75%">
                                    <?php echo e($sender); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">
                                    送信動画
                                </th>
                                <td style="width:75%">
                                    <?php if($video_url == ''): ?>
                                        [動画なし]
                                    <?php else: ?>
                                        [動画あり]
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">コメント</th>
                                <td style="width:75%">
                                    <?php echo nl2br(e($comment)); ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered my-2 table-condensed">
                        <thead class="bg-dark">
                            <th colspan="2">クライアント処理</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:25%">
                                    対応投稿日
                                </th>
                                <td style="width:75%">
                                    <?php echo e($response_date); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">承認または保留</th>
                                <td style="width:75%">
                                    <?php echo e($decision); ?>

                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">
                                    閲覧者
                                </th>
                                <td style="width:75%">
                                    <?php echo e($viewer); ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="text-xs text-dark">
                        作成日: <?php echo e($creation_date); ?>

                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</html>
<?php /**PATH /opt/bitnami/projects/waiton-dev/resources/views/layouts/permanent-record-pdf.blade.php ENDPATH**/ ?>