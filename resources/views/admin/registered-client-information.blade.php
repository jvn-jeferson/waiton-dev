@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            登録クライアント情報
                        </h3>
                    </div>
                    <div class="card-body">
                        <h4>
                            会計事務所：<strong class="text-dark">{{$office->name}}</strong>
                        </h4>
                        <h5>顧客情報</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-success">
                                    <th>事業者名</th>
                                    <th>顧客番号</th>
                                    <th>動画数</th>
                                </thead>
                                <tbody>
                                    @forelse($clients as $client)
                                        <tr>
                                            <td>{{$client->name}}</td>
                                            <td>{{$client->id}}</td>
                                            <td></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">表示できるデータがありません。</td>
                                        </tr>
                                    @endforelse
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
    <script src="{{asset('js/app.js')}}"></script>
@endsection