@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            登録状況サマリー
                        </h3>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="thead-dark">
                                    <th></th>
                                    <th>{{date('F')}}</th>
                                    <th><?php
                                            $now = date('Y-m-d H:i:s');
                                            $dt = new DateTimeImmutable($now, new DateTimeZone('Asia/Manila'));
                                            $dt = $dt->modify('-1 month');
                                            echo $dt->format('F')
                                        ?>
                                    </th>
                                    <th>
                                        <?php
                                            $now = date('Y-m-d H:i:s');
                                            $dt = new DateTimeImmutable($now, new DateTimeZone('Asia/Manila'));
                                            $dt = $dt->modify('-2 month');
                                            echo $dt->format('F')
                                        ?>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            ログイン件数
                                        </td>
                                        <td>100</td>
                                        <td>200</td>
                                        <td>200</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            会計事務所
                                        </td>
                                        <td>30</td>
                                        <td>28</td>
                                        <td>28</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            登録クライアント
                                        </td>
                                        <td>300</td>
                                        <td>290</td>
                                        <td>290</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            動画件数
                                        </td>
                                        <td>200</td>
                                        <td>180</td>
                                        <td>180</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-4 card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            登録状況（詳細）
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <th>会計事務所</th>
                                    <th>顧客番号</th>
                                    <th>顧客数</th>
                                    <th>顧客枠</th>
                                    <th>動画数</th>
                                    <th>初回登録日</th>
                                    <th>有効期限</th>
                                </thead>
                                <tbody>
                                    @forelse($accounting_firms as $firm)
                                        <tr>
                                            <td><a href="{{route('admin-registration-status', ['office' => $firm->id])}}">{{$firm->name}}</a></td>
                                            <td>{{$firm->id}}</td>
                                            <td>{{$firm->clients->count()}}</td>
                                            <td>{{1 ?? $firm->subscription->subscription_plan->max_clients}}</td>
                                            <td></td>
                                            <td>{{$firm->created_at->format('Y年m月d日 ')}}</td>
                                            <td></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                表示できるデータがありません。
                                            </td>
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
