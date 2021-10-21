@extends('layouts.client')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title text-primary text-bold">
                        登録情報
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-bold">会社名</td>
                                <td>
                                    ABC株式会社
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">当店の場所</td>
                                <td>
                                    ２ー６ー７ ひがしてんま、 きたーく、 おさかーし、 おさか
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">代表</td>
                                <td>
                                    たろ やまだ
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">代表住宅</td>
                                <td>
                                    １ー３ー２０ なかのしま、 きたーく、 おさかーし、 おさか
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">連絡先メールアドレス</td>
                                <td class="text-primary">
                                    yamada@abc.co.jp
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">NTA識別番号</td>
                                <td>
                                    1234 1231 1231
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold">パスワード</td>
                                <td class="text-encrypted">
                                    hello
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-danger card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-bold">
                        新しいユーザーを追加する
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td rowspan="2">
                                <label for="user-type">Type of access</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="a">
                                    <label class="form-check-label" for="exampleRadios1">
                                    User
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="b">
                                    <label class="form-check-label" for="exampleRadios2">
                                    Manager
                                    </label>
                                </div>
                            </td>
                            <td>Name</td>
                            <td><input type="text" name="" id="" class="form-control" placeholder="Full Legal Name"></td>
                            <td rowspan="2">
                                <button class="btn btn-primary btn-block">Register</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td><input type="email" name="" id="" class="form-control" placeholder="sample@mail.com"></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card card-danger card-outline collapsed-card">
                <div class="card-header">
                    <h3 class="card-title text-bold">
                        ユーザー管理
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </section>
    </div>
@endsection



@section('extra-scripts')
<!-- Scripts -->
<script src="{{asset('js/app.js')}}"></script>
@endsection