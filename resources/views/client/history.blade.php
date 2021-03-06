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
                    <h3 class="card-title">保管資料（動画あり）</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped table-bordered text-center">
                        <thead class="bg-primary">
                            <th>タイプ</th>
                            <th>決済日</th>
                            <th>確定申告</th>
                            <th>説明ビデオ</th>
                        </thead>
                        <tbody>
                            @forelse($archives as $archive)
                                <tr>
                                    <td>
                                        {{ $archive->kinds }}
                                    </td>
                                    <td>
                                        {{ $archive->settlement_date->format('Y年m月d日') }} <br>
                                        <button class="btn btn-primary btn-block" role="button"
                                            onclick="browsingConfirmation({{ $archive->id }})">閲覧</button>
                                    </td>
                                    <td class="text-info">
                                        {{ $archive->file->name }}
                                    </td>
                                    <td style="width:100px;">
                                        <div class="container-fluid" style="width:600px">
                                            {{ base64_encode($archive->video_url) }}
                                        </div>
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
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    var url = "{{ route('send-otp') }}";
                    axios.post(url, {
                        record_id: id,
                        table: 'taxation_histories'
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: '成功',
                        text: '登録したメールアドレスにワンタイムパスワードが送信されました。 メールを確認し、手順に従ってアクセスしてください。'
                    })
                }
            })
        }
    </script>
@endsection
