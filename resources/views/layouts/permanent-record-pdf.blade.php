<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{$title}}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid p-2">
        <div class="card" id="review_data">
            <div class="card-header justify-content-center align-items-center text-center">
                <h4 class="text-bold">
                    {{"From会計事務所データの承認等確認書"}}
                </h4>
                <h6>
                    {{"以下のデータについてのやりとりは以下の通り決定されています。"}}
                </h6>
            </div>
            <div class="card-body">
                <div class="">
                    <table class="table table-bordered my-2">
                        <tbody>
                            <tr>
                                <th class="w-25">クライアント名</th>
                                <td>
                                    {{-- Client Name --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">会計事務所名</th>
                                <td>
                                    {{-- Accounting Office Name --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">決定メール送付日</th>
                                <td>
                                    {{-- Decision Email Date --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered my-2 table-condensed">
                        <thead class="bg-gray">
                            <th class="w-25">会計事務所処理</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="w-25">送信ファイル名</th>
                                <td>
                                    {{-- file name --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">送信日</th>
                                <td>
                                    {{-- created_at --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">送信者</th>
                                <td>
                                    {{-- sender --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">
                                    送信動画
                                </th>
                                <td>
                                    {{-- video --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">承認の有無</th>
                                <td>
                                    {{-- if(priority=0)
                                    承認不要データ
                                    else --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">コメント</th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered my-2 table-condensed">
                        <thead class="bg-gray">
                            <th class="w-25">クライアント処理</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="w-25">初回閲覧日</th>
                                <td>
                                    {{-- viewing date --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">
                                    対応投稿日
                                </th>
                                <td>
                                    {{-- response date --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">承認または保留</th>
                                <td>
                                    {{-- approve or hold --}}
                                </td>
                            </tr>
                            <tr>
                                <th class="w-25">
                                    閲覧者
                                </th>
                                <td>
                                    viewer
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="text-xs text-dark">
                        作成日:
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</html>
