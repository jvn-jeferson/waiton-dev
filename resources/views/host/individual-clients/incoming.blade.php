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
                                <button class="btn btn-primary btn-block col-3 my-2" type="button" id="btnDownload">選択ファイルを一括ダウンロード</button>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
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
                                                    <td class="text-center"><input type="checkbox" name="select" id="select" value="{{$upload->file_id}}" @if($upload->file_id == null) disabled @endif></td>
                                                    <td>{{$upload->created_at->format('Y年m月d日 H:i')}}</td>
                                                    <td>{{$upload->created_at->modify('+1 month')->format('Y年m月d日 H:i')}}</td>
                                                    <td>{{$upload->user->clientStaff->name}}</td>
                                                    <td class="text-info"><a href="{{url(Storage::url($upload->file->path))}}" download="{{$upload->file->name}}">{{$upload->file->name}}</a></td>
                                                    <td>{{$upload->comment}}</td>
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
        $('#btnDownload').click(function() {
            var checkedBox = document.getElementsByName('select')
            var ids = [];
            for (var checkbox of checkedBox) {
                if(checkbox.checked)
                {
                    id = checkbox.value;

                    var url = "{{route('download-file')}}"
                    axios.post(url, {
                        file_id: id
                    }).then(function(response) {
                        const link = document.createElement('a')
                        link.href = response.data[0]
                        link.setAttribute('download', response.data[1]);
                        link.click();
                        document.removeChild(link);

                    }).catch(function(error) {
                        console.log(error.response.data);
                    })
                }
            }
        })
    </script>
@endsection