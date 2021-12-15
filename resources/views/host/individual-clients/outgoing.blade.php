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
                                <p class="text-bold">    
                                    アップロード資料にファイルをドロップするか、アップロードボタンからファイルを選択してください。
                                </p>
                                <div class="table-responsive mt-2">
                                    <form action="{{route('send-tax-file')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="client_id" id="client_id" value="{{$client->id}}" /> 
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr class="bg-info">
                                                    <td class="text-center" colspan="2">資料名</td>
                                                    <td class="text-center" >確認事項</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" rowspan="2"><input type="file" name="file" id="file" class="form-control d-block" accept=".doc,.docx,.pdf,.csv"></td>
                                                    <td><input type="radio" name="require_action" id="on" value="0">承認要求あり</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="radio" name="require_action" id="off" value="1">承認要求なし</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center bg-light">コメント</td>
                                                    <td colspan="2"><input type="text" name="comment" id="comment" class="form-control"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="submit" value="アップロード" class="btn btn-primary btn-block mt-2 col-3 float-right">
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
                                        <button class="btn btn-primary btn-block">選択したファイルを削除</button>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped text-center">
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
                                                        <tr @if($upload->priority <= 0) class="bg-light" @else class="bg-warning" @endif>
                                                            <td><input type="checkbox" name="record_id" id="record_id" value="{{ $upload->id }}"></td>
                                                            <td>{{$upload->created_at->format('Y年m月d日')}} • {{$upload->user->accountingOfficeStaff->name}}</td>
                                                            <td>{{$upload->created_at->modify('+1 month')->format('Y年m月d日')}}</td>
                                                            <td>
                                                                @if($upload->priority == 0)
                                                                    確認不要
                                                                @else
                                                                    @if($upload->status == 0) 
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
                                                            <td>@if($upload->modified_by_user_id){{$upload->updated_at->format('Y年m月d日')}} • {{$upload->editor->name}} • @if($upload->status == 1) 承認 @else 保留 @endif @endif </td>
                                                            <td class="text-info">{{$upload->file->name}}</td>
                                                            <td>{{$upload->details}}</td>
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
@endsection