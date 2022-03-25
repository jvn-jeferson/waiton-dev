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
                            @forelse($archives as $archive)
                                <tr>
                                    <td>
                                        {{$archive->kinds}}
                                    </td>
                                    <td>
                                        {{$archive->settlement_date->format('Y年m月d日')}} <br>
                                        <button class="btn btn-primary btn-block" role="button" onclick="browsingConfirmation({{$archive->id}})">閲覧</button>
                                    </td>
                                    <td class="text-info">
                                        {{$archive->file->name}}
                                    </td>
                                    <td>
                                        {{$archive->proposal_date->format('Y年m月d日')}} • {{$archive->recognition_date->format('Y年m月d日')}}
                                    </td>
                                    <td>
                                        {{$archive->video_url}}
                                    </td>
                                </tr>
                            @empty
                            @endforelse
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
            Swal.fire({
                title: "知らせ",
                icon: 'warning',
                text: "登録したメールアドレスにワンタイムパスワードが送信されますので、メールアドレスのURLからログインしてアクセスしてください。",
                showCancelButton: !0,
                confirmButtonText: "了解した",
                cancelButtonText: "キャンセル",
                showLoaderOnConfirm :true,
                preConfirm: function () {
                    var url = "{{route('send-otp')}}";
                    axios.post(url, {
                        record_id: id,
                        table: 'taxation_histories'
                    }).then(function(response){

                    }).catch(function(error){

                    });
                },
                allowOutsideClick : () => !Swal.isLoading()
            }).then((result)=>{
                Swal.fire({
                    icon: 'success',
                    title: '成功',
                    text: '登録したメールアドレスにワンタイムパスワードが送信されました。 メールを確認し、手順に従ってアクセスしてください。'
                })
            })
        }
    </script>
@endsection
