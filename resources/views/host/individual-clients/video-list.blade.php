@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            投稿リスト（表の線は分かりやすくするためにいれている）
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-info">
                                    <th>選択</th>
                                    <th>動画名</th>
                                    <th>動画名</th>
                                    <th>投稿日</th>
                                    <th>閲覧URL</th>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
@endsection