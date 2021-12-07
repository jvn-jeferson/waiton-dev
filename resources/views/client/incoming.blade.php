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
                    @forelse($host_uploads as $host_upload)
                    <table class="table table-bordered table-outline text-center my-2">
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
                                        {{$host_upload->created_at->format('Y年m月d日 g:i A')}}
                                    </p>
                                    <button class="btn btn-block btn-primary" onclick="downloadFile(this, 1)">資料のダウンロード</button>
                                </td>
                                <td rowspan="2">
                                    <p class="text-dark">
                                        {{$host_upload->created_at->modify('+1 month')->format('Y年m月d日 g:i A')}}
                                    </p>
                                </td>
                                <td rowspan="2" class="text-info">{{$host_upload->file->name}}</td>
                                <td class="text-center
                                    @switch($host_upload->status)
                                        @case(1)
                                            bg-light
                                            @break
                                        @case(2)
                                            bg-success
                                            @break
                                        @case(3)
                                            bg-light
                                            @break
                                        @case(4)
                                            bg-dark
                                            @break
                                        @default
                                            bg-light
                                            @break
                                    @endswitch
                                ">
                                    @if($host_upload->priority == 1)
                                        承認
                                    @else
                                        ---
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center
                                    @switch($host_upload->status)
                                        @case(1)
                                            bg-light
                                            @break
                                        @case(2)
                                            bg-light
                                            @break
                                        @case(3)
                                            bg-danger
                                            @break
                                        @case(4)
                                            bg-dark
                                            @break
                                        @default
                                            bg-light
                                            @break
                                    @endswitch
                                ">
                                    @if($host_upload->priority == 1)
                                        保留
                                    @else
                                        ---
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-light">
                                    コメント
                                </td>
                                <td colspan="2">
                                    {{$host_upload->details}}
                                </td>
                                <td>
                                    @if ($host_upload->priority == 1)
                                        <button class="btn btn-flat btn-block btn-primary">
                                            決定
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @empty

                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
<script>

    function downloadFile(e, id) {
        var file_id = id

        Swal.fire({
            title: 'Do you want to download this file?',
            text: 'After confirmation, the file will be downloaded on to your local computer.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4D9E17',
            cancelButtonColor: '#B30712',
            confirmButtonText: 'Proceed and download.'
        }).then((result) => {

            //axios get file
            //response
            if(result.isConfirmed) {
                Swal.fire(
                    'File Download will begin shortly.',
                    'Your file is ready for download.',
                    'success'
                )
            }
        })
    }
</script>
@endsection