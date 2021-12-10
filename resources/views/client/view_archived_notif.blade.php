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
                                                {{$record->file->name}} <br>
                                                <a class="btn btn-warning btn-block" type="button" href="{{ url(Storage::url($record->file->path))}}" download="{{$record->file->name}}">ダウンロード </a>
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
@endsection