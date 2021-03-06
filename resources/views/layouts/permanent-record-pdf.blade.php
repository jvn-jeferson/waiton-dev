<!DOCTYPE html>
<html lang="jp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="{{ asset('toppage_data/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('toppage_data/apple-touch-icon.png') }}">
    <title>{{ $title }}</title>
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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WV7L6QS" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <div class="container-fluid p-2">
        <div class="card" id="review_data">
            <div class="card-header justify-content-center align-items-center text-center">
                <h4 class="text-bold">
                    {{ 'From?????????????????????????????????????????????' }}
                </h4>
                <h6>
                    {{ '??????????????????????????????????????????????????????????????????????????????????????????' }}
                </h6>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table table-bordered my-2">
                        <tbody>
                            <tr>
                                <th style="width:25%">?????????????????????</th>
                                <td style="width:75%">
                                    {{ $client_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">??????????????????</th>
                                <td style="width:75%">
                                    {{ $accounting_office_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">????????????????????????</th>
                                <td style="width:75%">
                                    {{ $email_date }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered my-2 table-condensed">
                        <thead class="bg-dark">
                            <th colspan="2">?????????????????????</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:25%">?????????????????????</th>
                                <td style="width:75%">
                                    {{ $file_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">?????????</th>
                                <td style="width:75%">
                                    {{ $upload_date }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">?????????</th>
                                <td style="width:75%">
                                    {{ $sender }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">
                                    ????????????
                                </th>
                                <td style="width:75%">
                                    @if ($video_url == '')
                                        [????????????]
                                    @else
                                        [????????????]
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">????????????</th>
                                <td style="width:75%">
                                    {!! nl2br(e($comment)) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered my-2 table-condensed">
                        <thead class="bg-dark">
                            <th colspan="2">????????????????????????</th>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:25%">
                                    ???????????????
                                </th>
                                <td style="width:75%">
                                    {{ $response_date }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">?????????????????????</th>
                                <td style="width:75%">
                                    {{ $decision }}
                                </td>
                            </tr>
                            <tr>
                                <th style="width:25%">
                                    ?????????
                                </th>
                                <td style="width:75%">
                                    {{ $viewer }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="text-xs text-dark">
                        ?????????: {{ $creation_date }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</html>
