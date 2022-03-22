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
                                            {{ $host_upload->created_at->format('Y年m月d日 H:i') }}
                                        </p>
                                    </td>
                                    <td rowspan="2">
                                        <p class="text-dark">
                                            {{ $host_upload->created_at->modify('+1 month')->format('Y年m月d日 H:i') }}
                                        </p>
                                    </td>
                                    <td rowspan="2" class="text-info">
                                        @if ($host_upload->file)
                                            <a href="#" onclick="updateStatus({{$host_upload->id}}, this)" role="button">{{ $host_upload->file->name }}</a>
                                        @endif
                                    </td>
                                    <td
                                        class="text-center
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
                                            @break @endswitch
                                ">
                                        @if ($host_upload->priority == 0)
                                            承認
                                        @else
                                            ---
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="text-center
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
                                            @break @endswitch
                                ">
                                        @if ($host_upload->priority == 0)
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
                                        {{ $host_upload->details }}
                                    </td>
                                    <td rowspan="2">
                                        @if($host_upload->priority == 0)
                                        <button class="btn btn-flat btn-block btn-primary" role="button"
                                            onclick="admitFile({{ $host_upload->id }})">
                                            確認が必要
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light">
                                        URL
                                    </td>
                                    <td colspan="2">
                                        <a href="#"
                                            onclick="decrypt_video('{{ $host_upload->video_url }}')">{{ $host_upload->video_url }}</a>
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
    <script src="https://cdn.jsdelivr.net/npm/js-base64@3.7.2/base64.min.js"></script>
    <script>
        function decrypt_video(value) {
            var data = Base64.decode(value);
            if (isUrl(data)) {
                var valid_url = data
            } else {
                var valid_url = value
            }
            let a = document.createElement('a');
            a.target = '_blank';
            a.href = valid_url;
            a.click();
        }

        function isUrl(s) {
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
            return regexp.test(s);
        }


        function admitFile(post_id)
        {

            var url = "{{route('admit-host-upload')}}"

            Swal.fire({
                icon: 'question',
                title: '資料について承認・保留を決定してください',
                confirmButtonText: '承認',
                denyButtonText: '保留',
                cancelButtonText: 'キャンセル',
                showDenyButton: true,
                showCancelButton: true
            }).then((result) => {
                var status = 0;

                if(result.isConfirmed) {
                    Swal.fire({
                        title: "承認しますか？",
                        icon: 'question',
                        confirmButtonText: 'はい',
                        cancelButtonText: 'いいえ',
                        showCancelButton: true
                    }).then((approve) => {
                        if (approve.isConfirmed) {
                            axios.post(url, {
                                id: post_id,
                                status: 2
                            }).then(function(response) {
                                window.location.reload();
                            }).catch(function(error) {
                                console.log(error.response.data);
                            })
                        }
                    })
                }else if(result.isDenied){
                    Swal.fire({
                        title: "保留しますか？",
                        icon: 'warning',
                        confirmButtonText: 'はい',
                        cancelButtonText: 'いいえ',
                        showCancelButton: true
                    }).then((deny) => {
                        if(deny.isConfirmed) {
                            axios.post(url, {
                                id: post_id,
                                status: 3
                            }).then(function (response) {
                                window.location.reload()
                            }).catch(function (error) {
                                console.log(error.response.data)
                            })
                        }
                    })
                }
            })
        }

        function updateStatus(post_id)
        {
            Swal.showLoading()
            var url = "{{route('download-host-file')}}"

            axios.post(url, {
                record_id: post_id
            }).then(function(response) {
                if(Swal.isLoading())
                {
                    Swal.hideLoading()
                }
                const link = document.createElement('a')
                link.href = response.data[0]
                link.setAttribute('download', response.data[1]);
                link.click();
                document.removeChild(link);
                button.disabled = 'disabled'
            }).catch(function(error) {
                console.log(error.response);
            })
        }
    </script>
@endsection
