@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    会計事務所へのメール
                                </h3>
                            </div>
                            <div class="card-body">
                                <h5>会計事務所向けにメールを送ります。</h5>
                                <div class="table-responsive">
                                    <div class="alert-info p-5">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="title">表題</label>
                                                <input type="text" name="title" id="title" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="article">表題</label>
                                                <textarea name="article" id="article" rows="20" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group form-row">
                                                <input type="file" name="attachment" id="attachment" class="col-3">
                                                <div class="col-6"></div>
                                                <input type="submit" value="送信" class="col-3 btn btn-warning">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-dark card-outline p-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    投稿履歴
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <button class="btn btn-primary col-3" type="button">選択した投稿を削除</button>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead class="bg-light">
                                                <th>選択</th>
                                                <th>投稿日</th>
                                                <th>表題</th>
                                                <th>コメント</th>
                                                <th>投稿資料</th>
                                            </thead>
                                            <tbody>
                                                @forelse($posts as $post)
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">No records to show.</td>
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
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection