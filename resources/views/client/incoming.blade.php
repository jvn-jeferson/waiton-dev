@extends('layouts.client')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-primary">
                        経理部から受け取ったデータ（閲覧期限1ヶ月）
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        以下のファイルが会計事務所から送信されました。承認が必要な資料については、承認/予約を確認して選択し、処理を決定してください。 コメントを送信することもできます。 （視聴期限は1ヶ月です)
                    </p>
                    <table class="table table-bordered table-outline text-center">
                        <thead class="thead-dark">
                            <th>投稿情報</th>
                            <th>締め切りの表示</th>
                            <th>ドキュメントのタイトル</th>
                            <th>オプション</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="2">
                                    <p class="text-dark">
                                        2021年5月2日午後3時30分
                                    </p>
                                    <button class="btn btn-block btn-primary">資料のダウンロード</button>
                                </td>
                                <td rowspan="2">
                                    <p class="text-dark">
                                        2021年6月2日午後3時30分
                                    </p>
                                </td>
                                <td rowspan="2">財務諸表/確定申告（法人税、地方税、消費税）/ FYO3 / 20201</td>
                                <td class="text-center bg-danger">Admit</td>
                            </tr>
                            <tr>
                                <td class="text-center bg-danger">
                                    Reserve
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    コメント
                                </td>
                                <td colspan="3">
                                    今年の財務諸表。
                                    税額一覧とともに最終確認をお願いします
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>
@endsection