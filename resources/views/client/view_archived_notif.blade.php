@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-left">
                        <h3 class="card-title text-dark text-bold">
                            保存資料（動画なし）
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="bg-info text-bold text-center">
                                    <th>種類</th>
                                    <th>資料</th>
                                    <th>投稿者</th>
                                </thead>
                                <tbody>
                                    @if($record)
                                        <tr class="text-center">
                                            <td class="text-bold">
                                                {{$record->notification_type ?? '不明'}}
                                            </td>
                                            <td>
                                                <a href="#" onclick="downloadFile({{$record->file->id}}, this)">{{$record->file->name}}</a>
                                            </td>
                                            <td>
                                                {{$record->uploader->name}}
                                            </td>
                                        </tr>
                                    @else
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" role="dialog" tabindex="-1" id="notifDataModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">レコード番号 : <strong id="notif_id"></strong> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Temporary waiting for additional data.
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')

    <script>

        function showNotifData(id)
        {
            var notifDataModal = document.querySelector('#notifDataModal')

            notifDataModal.modal('show')
        }

        function downloadFile(id, button)
        {
            var url = "{{route('download')}}"

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
                    text: error.response.data['message'],
                    icon: 'danger',
                    showCancelButton: false
                })
            })
        }
    </script>
@endsection
