@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="card-body">
                                <p class="text-bold">
                                    クライアント宛に、以下で資料をアップロードします。
                                </p>
                                <div class="table-responsive mt-2">
                                    <form action="{{ route('send-tax-file') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="client_id" id="client_id" value="{{ $client->id }}" />
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr class="bg-info">
                                                    <td class="text-center" colspan="2">資料名</td>
                                                    <td class="text-center">確認事項</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" rowspan="2"><input type="file" name="file" id="file"
                                                            class="form-control d-block"></td>
                                                    <td><input type="radio" name="require_action" id="on" value="0">承認要求あり
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="require_action" id="off" value="1">承認要求なし

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center bg-light">コメント</td>
                                                    <td colspan="2"><textarea name="comment" id="comment"
                                                            class="form-control" rows="5"></textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center bg-light">ビデオのURL</td>
                                                    <td colspan="2"><input type="text" name="vid_url" id="vid_url"
                                                            class="form-control"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="submit" value="アップロード"
                                            class="btn btn-primary btn-block mt-2 col-3 float-right">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">承認依頼履歴</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <button class="btn btn-primary btn-block" id="delete-from">選択したファイルを削除</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped text-center" id="resourceTable">
                                                <thead class="thead-dark">
                                                    <th>選択</th>
                                                    <th>UP • 日時 • だれが</th>
                                                    <th>閲覧期限</th>
                                                    <th>対応</th>
                                                    <th>対応 • 日時 • だれが</th>
                                                    <th>資料名</th>
                                                    <th>コメント</th>
                                                </thead>
                                                <tbody>
                                                    @forelse($uploads as $upload)
                                                        <tr @if ($upload->priority == 1 || $upload->status != 0) class="bg-light" @else class="bg-warning" @endif>
                                                            <td><input type="checkbox" name="select" id="select"
                                                                    value="{{ $upload->id ?? '' }}"></td>
                                                            <td>{{ $upload->created_at->format('Y年m月d日') }} <br />
                                                                {{ $upload->user->accountingOfficeStaff->name }}</td>
                                                            <td>{{ $upload->created_at->modify('+1 month')->format('Y年m月d日') }}
                                                            </td>
                                                            <td>
                                                                @if ($upload->priority == 1)
                                                                    確認不要
                                                                @else
                                                                    @if ($upload->status == 0)
                                                                        アップロードされました
                                                                    @elseif($upload->status == 1)
                                                                        ダウンロードされました
                                                                    @elseif($upload->status == 2)
                                                                        承認済み
                                                                    @elseif($upload->status == 3)
                                                                        留保
                                                                    @else
                                                                        確認不要
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>@if ($upload->modified_by_user_id){{ $upload->updated_at->format('Y年m月d日') }} • {{ $upload->editor->name ?? ''}} • @if ($upload->status == 1) 承認 @else 保留 @endif @endif </td>
                                                            <td class="text-info"><a
                                                                    href="#" onclick="downloadFile({{$upload->file->id}}, this)">{{ $upload->file->name ?? ''}}
                                                                </a>
                                                            </td>
                                                            <td><button class="btn btn-light btn-block" onclick="displayfulltext({{json_encode($upload->details)}})">{{ substr($upload->details,0, 10) }} ...</button></td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
        $('#resourceTable').DataTable()
        // var selects = document.getElementsByName('record_id');
        // $.each(selects, function(index, value) {
        //     selects[index].checked = false
        // });
        var deletes = document.getElementById('delete-from');

        deletes.addEventListener('click', function() {
            Swal.fire({
                title: "履歴を削除しますか？",
                showCancelButton: !0,
                confirmButtonText: "削除",
                cancelButtonText: "キャンセル",
                preConfirm : function () {
                    var record_id = $('input#select:checked').map(function() {
                        return this.value
                    }).get()
                    var url = "{{route('delete-file-from')}}";
                    axios.post(url, {data:record_id}).then(function(){
                        console.log('hehe')
                    }).catch(function(error){
                        console.log(error.response.data)
                    });
                },
                showLoaderOnConfirm : true,
                allowOutsideClick :  () => !Swal.isLoading()
            }).then((result) => {
                if(result.isConfirmed) {
                    Swal.fire({
                        icon: 'success',
                        title: '履歴が削除されました'
                    }).then((result) => {
                        window.location.reload()
                    })
                }
            });
        });


        $(function() {
            $('form').submit(function(e) {
                Swal.showLoading()
            })
        })

        function displayfulltext(comment){

            comment.replace('\n', '<br />')
            Swal.fire({
                title: 'コメント',
                html: '<pre class="text-justify">' + comment + '</pre>',
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: true
            })
        }

        function downloadFile(id, button)
        {
            var url = "{{route('download-document-files')}}"

            axios.post(url, {
                file_id: id
            }).then(function (response) {
                const link = document.createElement('a')
                link.href = response.data[0]
                link.setAttribute('download', response.data[1]);
                link.click();
                button.disabled = 'disabled'
            }).catch(function (error) {
                Swal.fire({
                    title: "ERROR",
                    text: error.message,
                    icon: 'danger',
                    showCancelButton: false
                })
            })
        }
    </script>
@endsection
