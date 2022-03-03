@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-left">
                        <h3 class="card-title text-dark text-bold">
                            過去の届出等の履歴
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="bg-info text-bold text-center">
                                    <th>種類</th>
                                    <th>提出日</th>
                                    <th>承認日</th>
                                    <th>資料</th>
                                    <th>アップローダー</th>
                                </thead>
                                <tbody>
                                    @if($record)
                                        <tr class="text-center">
                                            <td class="text-bold">
                                                {{$record->notification_type ?? '不明'}}
                                            </td>
                                            <td>
                                                @if($record->proposal_date)
                                                    {{$record->proposal_date->format('Y-m-d')}}
                                                @else
                                                    不明
                                                @endif
                                            </td>
                                            <td>
                                                @if ($record->recognition_date)
                                                    {{$record->recognition_date->format('Y-m-d')}}
                                                @else
                                                    不明
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{Storage::disk('gcs')->url($record->file->path)}}" download="{{$record->file->name}}">{{$record->file->name}}</a>
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
    </script>
@endsection
