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
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->establishment_notification == 1)checked @endif @endif>
                                    設立通知フォーム
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->blue_declaration == 1)checked @endif @endif>
                                    ブルー宣言の申請
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->withholding_tax == 1)checked @endif @endif>
                                    源泉徴収税の特別納期
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->salary_payment == 1)checked @endif @endif>
                                    給与支給事務所等への通知
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->extension_filing_deadline == 1)checked @endif @endif>
                                    提出期限延長の申請
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->consumption_tax == 1)checked @endif @endif>
                                    消費税課税事業者
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->consumption_tax_excemption == 1)checked @endif @endif>
                                    消費税免税事業者への通知
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="" id="" disabled @if($account->notifs) @if($account->notifs->consumption_tax_selection == 1)checked @endif @endif>
                                    消費税課税事業者選定通知書
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-primary">
                    <div class="card-header">
                        過去の届出等へのアクセス
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="bg-info text-bold">
                                    <th>種類</th>
                                    <th>提出日</th>
                                    <th>承認日</th>
                                    <th>資料</th>
                                </thead>
                                <tbody>
                                    @forelse($records as $record)
                                        <tr class="text-center">
                                            <td>
                                                @if($record->notification_type)
                                                {{$record->notification_type}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($record->proposal_date)
                                                {{$record->proposal_date->format('Y年m月d日')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($record->recognition_date)
                                                {{$record->recognition_date->format('Y年m月d日')}}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url(Storage::disk('gcs')->url($record->file->path))}}" download="{{$record->file->name}}">{{$record->file->name}}</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-info">
                                                レコードが見つかりません。
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                    var url = "{{route('send-otp')}}";
                    axios.post(url, {
                        record_id: id,
                        table: 'past_notifications'
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
