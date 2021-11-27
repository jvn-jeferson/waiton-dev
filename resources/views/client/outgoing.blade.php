@extends('layouts.client')

@section('extra-css')
    
@endsection

@section('content')
    <!-- Main Wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <section class="content">
            <!-- Upload Files -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-success">
                        経理部にデータを送信（閲覧期限1ヶ月)
                    </h3>
                    
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        次のファイルを経理部にアップロードします。アップロード資料にファイルをドロップするか、アップロードボタンからファイルを選択します。
                    </p>
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="thead bg-dark">
                            <th>アップロードされた資料</th>
                            <th>備考</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="file" name="file[]" id="file" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="comment[]" id="comment" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" name="file[]" id="file" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="comment[]" id="comment" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" name="file[]" id="file" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="comment[]" id="comment" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" name="file[]" id="file" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="comment[]" id="comment" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="file" name="file[]" id="file" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="comment[]" id="comment" class="form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="float-right btn btn-success" type="submit">アップロード</button>
                </div>
            </div>
            <!-- /upload files -->

            <!-- Upload List -->
            <div class="card card-warning card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-dark">
                        アップロードされたファイル
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 4px">
                        <button class="float-left btn btn-primary" type="button">Delete Selected File</button>
                    </div>
                    <br>
                    <div class="mt-2">
                        <table class="table table-hover table-bordered">
                            <thead class="thead-dark text-center">
                                <th>撰ぶ</th>
                                <th>投稿日</th>
                                <th>締め切りの表示</th>
                                <th>寄稿者</th>
                                <th>ファイル名</th>
                                <th>備考</th>
                            </thead>
                            <tbody class="text-center">
                                {{-- foreach $file in $files --}}
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>2021年4月10日21:40</td>
                                    <td>2021年5月10日21:40</td>
                                    <td>Ichikawa-san</td>
                                    <td class="text-info">sample.pdf</td>
                                    <td>ありがとうございました</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /upload list -->
        </section>
        <!-- End Content -->
    </div>
    <!-- end Main Wrapper -->
@endsection

@section('extra-scripts')
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>

<script>
    
</script>
@endsection