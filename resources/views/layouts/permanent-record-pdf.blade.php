<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}

    <title>{{ $title }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
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

        @page {
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
    <div class="container-fluid p-2">
        <div class="card" id="review_data">
            <div class="card-header justify-content-center align-items-center text-center">
                <h4 class="text-bold">
                    {{ 'From会計事務所データの承認等確認書' }}
                </h4>
                <h6>
                    {{ '以下のデータについてのやりとりは以下の通り決定されています。' }}
                </h6>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table table-bordered my-2">
                        <tbody>
                            <tr>
                                <th style="width:25%">クライアント名</th>
                                <td style="width:75%">
                                    {{ $client_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">会計事務所名</th>
                                <td style="width:75%">
                                    {{ $accounting_office_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">決定メール送付日</th>
                                <td style="width:75%">
                                    {{ $email_date }}
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
                                    {{ $file_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">送信日</th>
                                <td style="width:75%">
                                    {{  $upload_date  }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">送信者</th>
                                <td style="width:75%">
                                    {{ $sender }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">
                                    送信動画
                                </th>
                                <td style="width:75%">
                                    @if($video_url == '')
                                        [動画なし]
                                    @else
                                        [動画あり]
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">コメント</th>
                                <td style="width:75%">
                                    {!! nl2br(e($comment)) !!}
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
                                    {{  $response_date  }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">承認または保留</th>
                                <td style="width:75%">
                                    {{ $decision }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">
                                    閲覧者
                                </th>
                                <td style="width:75%">
                                    {{ $viewer }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="text-xs text-dark">
                        作成日: {{ $creation_date}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</html>
