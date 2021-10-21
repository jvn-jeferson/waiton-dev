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
                    <h3 class="card-title">
                        <strong class="text-info">現在の通知ステータス</strong> 
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table-bordered table">
                        <tbody>
                            <tr>
                                <td>会社名</td>
                                <td>
                                    ABC株式会社
                                </td>
                            </tr>
                            <tr>
                                <td>当店の場所</td>
                                <td>
                                    ２ー６ー７ ひがしてんま、 きたーく、 おさかーし、 おさか
                                </td>
                            </tr>
                            <tr>
                                <td>代表</td>
                                <td>
                                    たろ やまだ
                                </td>
                            </tr>
                            <tr>
                                <td>代表住宅</td>
                                <td>
                                    １ー３ー２０ なかのしま、 きたーく、 おさかーし、 おさか
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="8">主要な通知の状況など</td>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    設立通知フォーム
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    ブルー宣言の申請
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    源泉徴収税の特別納期
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    給与支給事務所等への通知
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled>
                                    提出期限延長の申請
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    消費税課税事業者
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    消費税免税事業者への通知
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled checked>
                                    消費税課税事業者選定通知書
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body justify-items-center">
                    <p class="text-dark h2">
                        過去の通知フォームなどへのアクセス
                    </p>
                    <button class="btn btn-primary" onclick="confirmAccessRequest(1)">ブラウジング</button>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        function confirmAccessRequest(id) {
            swal.fire({
                title: "機密情報へのアクセスの閲覧",
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