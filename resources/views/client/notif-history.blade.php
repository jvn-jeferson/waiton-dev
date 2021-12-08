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
                                <td class="text-bold bg-lightblue">会社名</td>
                                <td class="text-dark text-bold">
                                    {{$account->name}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue">当店の場所</td>
                                <td>
                                    {{$account->address}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue">代表</td>
                                <td>
                                    {{$account->representative}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue">代表住宅</td>
                                <td>
                                    {{$account->representative_address}}
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="8" class="text-bold bg-lightblue">主要な通知の状況など</td>
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
                    <button class="btn btn-primary" onclick="confirmAccessRequest({{$account->id}})">ブラウジング</button>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
    <script>
        function confirmAccessRequest(id) {
            Swal.fire({
                title: "機密情報へのアクセスの閲覧",
                text: "登録したメールアドレスにワンタイムパスワードが送信されますので、メールアドレスのURLからログインしてアクセスしてください。",
                showCancelButton: !0,
                confirmButtonText: "閲覧する",
                cancelButtonText: "キャンセル",
                reverseButtons: false
            }).then((result) => {
                if(result.isConfirmed)
                {
                    var url = "{{route('send-otp-notif-history')}}";
                    axios.post(url, {
                        client_id: id
                    }).then(function(response) {
                        Swal.fire({
                            title: '成功',
                            icon: 'success',
                            text: '登録したメールアドレスにワンタイムパスワードが送信されました。 メールを確認し、手順に従って会社の通知履歴にアクセスしてください。'
                        })
                    }).catch(function(error){
                        Swal.fire({
                            title: 'エラー',
                            icon: 'warning',
                            text: 'エラーが発生しました。 もう一度やり直してください。'
                        })
                    })
                }
            })
        }
    </script>
@endsection