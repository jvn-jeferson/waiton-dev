@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header text-dark">
                                <h2 class="card-title">アップロードリスト（閲覧期限) <small>以下のファイルがクライアントからアップロードされています。</small></h2>
                                <p class="card-subtitle"></p>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-primary btn-block col-3 my-2" type="button"
                                    id="btnDownload">選択ファイルを一括ダウンロード</button>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-dark">
                                            <th>選択</th>
                                            <th>投稿日</th>
                                            <th>閲覧期限</th>
                                            <th>投稿者</th>
                                            <th>投稿資料</th>
                                            <th>コメント</th>
                                        </thead>
                                        <tbody>
                                            @forelse($uploads as $upload)
                                                <tr>
                                                    <td class="text-center">
                                                        <input type="checkbox" name="select"
                                                            id="select" value="{{ $upload->id }}"
                                                            @if ($upload->file_id == null) disabled @endif></td>
                                                    <td>{{ $upload->created_at->format('Y年m月d日 H:i') }}</td>
                                                    <td>{{ $upload->created_at->modify('+1 month')->format('Y年m月d日 H:i') }}
                                                    </td>
                                                    <td>{{ $upload->user->clientStaff->name }}</td>
                                                    <td class="text-info"><a href="#" onclick="markAsRead(
                                                                    {{ $upload->id }}, this)"
                                                            role="button">{{ $upload->file->name }}</a></td>
                                                    <td>{!! nl2br(e($upload->comment)) !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-success">
                                                        クライアントからの新しいアップロードはありません。
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
    <script>
        var download = document.querySelector('#btnDownload')

        download.addEventListener('click', function() {
            var file_id = $('input#select:checked').map(function() {
                return this.value
            }).get()

            var url = "{{ route('download-file') }}"
            axios.post(url, {
                file_id: file_id
            }).then(function(response) {
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Success',
            //     text: 'Congrats you Download Files'
            // })

            function download_files(files) {
                function download_next(i) {
                    if (i >= files.length) {
                        return;
                    }
                    var a = document.createElement('a');
                    a.href = files[i].file_url;
                    a.target = '_blank';

                    if ('download' in a) {
                        a.download = files[i].file_name;
                    }

                    (document.body || document.documentElement).appendChild(a);
                    if (a.click) {
                        a.click(); // The click method is supported by most browsers.
                    } else {
                        window.open(files[i].file_url);
                    }
                    a.parentNode.removeChild(a);
                    setTimeout(function() {
                        download_next(i + 1);
                    }, 500);
                }
                // Initiate the first download.
                download_next(0);
            }

            function do_dl() {
            var data = response.data;
                download_files(data);
            };
            do_dl();
            }).then(function() {
                // window.location.reload();
            }).catch(function(error) {
                console.log(error.response.data);
            })
        })

        function markAsRead(target, button) {
            var url = "{{ route('mark-as-read') }}"

            axios.post(url, {
                record_id: target
            }).then(function(response) {
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
