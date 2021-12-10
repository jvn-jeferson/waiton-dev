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
                                    <button class="btn btn-block btn-primary" onclick="downloadFile(this, {{$host_upload->file_id}})">資料のダウンロード</button>
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
                                            bg-success
                                            @break
                                        @case(2)
                                            bg-light
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
                                            bg-danger
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
                                    @if ($host_upload->priority == 1 && $host_upload->status <= 0)
                                        <button class="btn btn-flat btn-block btn-primary" role="button" onclick="admitFile({{$host_upload->id}})">
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
        var file = id

        Swal.fire({
            title: 'Do you want to download this file?',
            text: 'After confirmation, the file will be downloaded on to your local computer.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4D9E17',
            cancelButtonColor: '#c6c6c6',
            confirmButtonText: 'Proceed and download.'
        }).then((result) => {

            //axios get file
            //response
            if(result.isConfirmed) {
                Swal.fire(
                    'File Download will begin shortly.',
                    'Your file is ready for download.',
                    'success'
                ).then((result) => {
                    var url = "{{route('download')}}";
                    axios.post(url, {
                        file_id: file
                    }).then(function (response) {
                        const link = document.createElement('a')
                        link.href = response.data[0]
                        link.setAttribute('download', response.data[1]);
                        link.click();
                        document.removeChild(link);
                    }).catch(function (response) {
                        console.log(response.error.data);
                    })
                })
            }
        })
    }

    function admitFile(post_id)
    {
        var url = "{{route('admit-host-upload')}}"
        Swal.fire({
            icon: 'question',
            title: 'Consider',
            text: 'Would you like to admit or reserve this statement?',
            confirmButtonText: 'Admit',
            cancelButtonText: 'Reserve',
            showCancelButton: true
        }).then((result) => {
            var status = 0;
            if(result.isConfirmed){
                status = 1
            }else {
                status = 2
            }

            axios.post(url, {
                id: post_id,
                status: status
            }).then(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Action Completed',
                    text: response.data,
                }).then((result) => {
                    window.location.reload();
                })
            }).catch(function(error) {
                console.log(error.response.data);
            })
        })
    }
</script>
@endsection