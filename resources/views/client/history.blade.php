@extends('layouts.client')

@section('extra-css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">過去の決算</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered text-center">
                        <thead class="bg-primary">
                            <th>タイプ</th>
                            <th>決済日</th>
                            <th>確定申告</th>
                            <th>出願日 • 承認日</th>
                            <th>説明ビデオ</th>
                        </thead>
                        <tbody>
                            <tr >
                                <td class="my-auto">確認済み</td>
                                <td>
                                    <p class="text-muted my-auto">2021年３月31日</p>
                                    <button class="btn btn-block btn-primary" type="button" onclick="browsingConfirmation(2)">ブラウジング</button>
                                </td>
                                <td>財務諸表/確定申告（法人税/地方税/消費税）2021年度</td>
                                <td>2021年5月28日 • 2021年5月30日</td>
                                <td>
                                    <img src="{{asset('img/placeholder-image.png')}}" alt="" width="144px" height="144px">
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
    <script>
        function browsingConfirmation(id) {
            swal.fire({
                title: "知らせ",
                icon: 'warning',
                text: "登録したメールアドレスにワンタイムパスワードが送信されますので、メールアドレスのURLからログインしてアクセスしてください。",
                showCancelButton: !0,
                confirmButtonText: "了解した",
                cancelButtonText: "キャンセル",
                reverseButtons: false
            })
        }
    </script>
@endsection