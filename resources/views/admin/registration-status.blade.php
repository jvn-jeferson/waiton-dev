@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-dark card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            登録事務所情報
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>事務所番号</th>
                                        <th>{{$office->id}}</th>
                                    </tr>
                                    <tr>
                                        <td>事務所名</td>
                                        <td>{{$office->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>所在地</td>
                                        <td>{{$office->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>代表者
                                        </td>
                                        <td>{{$office->representative}}</td>
                                    </tr>
                                    <tr>
                                        <td>ご利用</td>
                                        <td>{{'FREE USER' ?? $office->subscription->subscription_plan->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>ご利用期日</td>
                                        <td>{{$office->created_at->format('Y/m/d')}} ~ {{$office->created_at->modify('+1 year')->format('Y/m/d')}}</td>
                                    </tr>
                                    <tr>
                                        <td>購入枠数</td>
                                        <td>{{1 ?? $office->subscription->subscription_plan->max_clients}}</td>
                                    </tr>
                                    <tr>
                                        <td>登録メールアドレス</td>
                                        <td>{{$office->contact_email}}</td>
                                    </tr>
                                    <tr>
                                        <td>管理者ID</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>パスワード </td>
                                        <td><button class="btn-primary btn btn-flat mx-2">PWの再発行</button><button class="btn-success btn btn-flat mx-2">ワンタイムログイン</button></td>
                                    </tr>
                                    <tr>
                                        <td>クライアント数</td>
                                        <td><a href="{{route('admin-registered-client-information', ['office_id'=>$office->id])}}">{{$clients->count()}}</a></td>
                                    </tr>
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