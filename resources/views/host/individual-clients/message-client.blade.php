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
                                <form action="" method="post" enctype="multipart/form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="scheduled_at">指定日（設定しない場合は、投稿日で連絡されます）</label>
                                        <input type="date" name="scheduled_at" id="scheduled_at" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="contents">コメント欄</label>
                                        <input type="text" name="contents" id="contents" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="file">Attach a File</label>
                                        <input type="file" name="file" id="file">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="登録" name="submit" class="btn btn-warning float-right">
                                    </div>
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
                                            {{-- @foreach ($records as $record) --}}
                                                <tr>
                                                    <td><input type="checkbox" name="" id=""></td>
                                                    <td>2021/06/15</td>
                                                    <td></td>
                                                    <td>Notice</td>
                                                    <td>We would like to express our deepest sympathies during the heat.
                                                        Let's do our best without being overwhelmed by Corona.
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            {{-- @endforeach --}}
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
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@endsection