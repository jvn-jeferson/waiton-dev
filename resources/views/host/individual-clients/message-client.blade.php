@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    対象顧客への連絡
                                </h3>
                            </div>
                            <div class="card-body">
                                <p class="text-dark h4">向けに連絡を行うことができます</p>
                                <form method="post" id="messageClientForm" action="{{route('message-client')}}" enctype="multipart/form-data">
                                    <div class="m-3 p-3 alert-info">
                                            @csrf
                                            <input type="hidden" name="client_id" id="client_id" value="{{$client->id}}">
                                            <div class="form-group">
                                                <label for="scheduled_at">指定日（設定しない場合は、投稿日で連絡されます）</label>
                                                <input type="date" name="scheduled_at" id="scheduled_at" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="content">コメント欄</label>
                                                <input type="text" name="content" id="content" class="form-control" required/>
                                            </div>
                                            <div class="form-group">
                                                <label for="attachment">ファイルを添付</label>
                                                <input type="file" name="attachment" id="attachment">
                                            </div>
                                    </div>
                                    <input type="submit" value="登録" name="submit" class="btn btn-warning float-right mx-3 col-2">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-success card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title text-dark">投稿履歴</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="thead bg-light">
                                            <th>選択</th>
                                            <th>投稿日</th>
                                            <th>指定日</th>
                                            <th>コメント</th>
                                            <th>投稿資料</th>
                                        </thead>
                                        <tbody>
                                            <button class="btn btn-primary btn-block col-3 mb-3">選択した投稿を削除</button>
                                            @forelse($messages as $message)
                                                <tr>
                                                    <td><input type="checkbox" name="select" id="select" value="{{$message->id}}"></td>
                                                    <td>{{$message->created_at}}</td>
                                                    <td>{{$message->scheduled_at}}</td>
                                                    <td>{{$message->contents}}</td>
                                                    <td>{{$message->file->name ?? ''}}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-info">クライアント<strong class="text-success">{{$client->name}}</strong>を対象としたメッセージはありません。</td>
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
@endsection