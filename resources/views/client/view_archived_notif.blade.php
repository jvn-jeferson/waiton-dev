@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-left">
                        <h3 class="card-title text-dark text-bold">
                            過去の届出等の履歴
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead class="bg-info text-bold">
                                    <th>種類</th>
                                    <th>提出日</th>
                                    <th>承認日</th>
                                    <th>資料</th>
                                    <th>意見</th>
                                </thead>
                                <tbody>
                                    @forelse($records as $record)
                                        <tr class="text-center">
                                            <td>

                                            </td>
                                            <td>
                                                {{$record->proposal_date->format('Y年m月d日')}}
                                            </td>
                                            <td>
                                                {{$record->recognition_date->format('Y年m月d日')}}
                                            </td>
                                            <td>
                                                <a href="{{ url(Storage::disk('gcs')->url($record->file->path))}}" download="{{$record->file->name}}">{{$record->file->name}}</a>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary" type="button" onclick="showNotifData({{$record->id}})"><i class="fa fa-eye"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-info">
                                                レコードが見つかりません。
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
