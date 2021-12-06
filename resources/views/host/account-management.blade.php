@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">登録情報</h3>
                                <div class="card-tools">
                                    @if(Auth::user()->role_id == 2)
                                        <button class="btn btn-warning btn-tool text-light" id="btn-swal">変更・登録</button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold">事務所名</td>
                                                <td>{{$account->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>代表者</td>
                                                <td>{{$account->representative}}</td>
                                            </tr>
                                            <tr>
                                                <td>所在地</td>
                                                <td>{{$account->address}}</td>
                                            </tr>
                                            <tr>
                                                <td>電話番号</td>
                                                <td>{{$account->telephone}}</td>
                                            </tr>
                                            <tr>
                                                <td>ご利用</td>
                                                <td>Paid member</td>
                                            </tr>
                                            <tr>
                                                <td>選択プラン</td>
                                                <td>5 company plan</td>
                                            </tr>
                                            <tr>
                                                <td>利用者数</td>
                                                <td>4 社</td>
                                            </tr>
                                            <tr>
                                                <td>ご利用期日</td>
                                                <td>2021/3/1　～　2022/2/28　初回登録 {{$account->verified_at}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-sm-12 col-md-12">
                        <div class="card card-danger card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    新規登録
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="post" id="newUserForm">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="mb-2 table table-bordered">
                                            <tbody class="text-center align-items-center">
                                                <tr>
                                                    <td class="bg-light" rowspan="2">
                                                        <label for="" class="h3">
                                                            <input type="radio" name="is_admin" id="is_admin" value="1">利用者 
                                                        </label><br>
                                                        <label for="" class="h3">
                                                            <input type="radio" name="is_admin" id="is_admin" value="0">管理者 
                                                        </label>
                                                    </td>
                                                    <td>名前</td>
                                                    <td class="bg-light"><input type="text" name="name" id="name" class="form-control bg-light"></td>
                                                </tr>
                                                <tr>
                                                    <td>メールアドレス</td>
                                                    <td class="bg-light"><input type="email" name="email" id="email" class="form-control bg-light"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-9"></div>
                                        <div class="col-3">
                                            <input type="submit" value="新規登録" class="btn btn-warning btn-block text-bold">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-danger card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    ログイン情報
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td rowspan="2" class="text-center h3">管理者</td>
                                                <td>ID</td>
                                                <td>Z0123456</td>
                                            </tr>
                                            <tr>
                                                <td>名前</td>
                                                <td>市川欽一</td>
                                            </tr>
                                            <tr>
                                                <td><button class="btn btn-info btn-flat btn-block">編集</button></td>
                                                <td>パスワード</td>
                                                <td class="bg-gray">********</td>
                                            </tr>
                                            <tr>
                                                <td><button class="btn btn-danger btn-flat btn-block">削除</button></td>
                                                <td>メールアドレス</td>
                                                <td class="bg-gray">ichikawa@gmial.com</td>
                                            </tr>
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
    <script>
        
        $("#newUserForm").on('submit', function(event) {
            event.preventDefault()
            
            var url = "{{route('register-new-staff')}}"
            var is_admin_check = $('#is_admin').val()
            axios.post(url, {
                is_admin : is_admin_check,
                name: $('#name').val(),
                email: $('#email').val()
            }).then(function(response) {
                Swal.fire({
                    title: 'ユーザーの作成に成功',
                    icon: 'success',
                    position: 'top-end'
                }).then((result) => {
                   if(result.isConfirmed) {
                    $('#name').val('')
                    $('#email').val('')
                    $('#is_admin').checked = false
                   } 
                })
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Check your inputs and try again.',
                })
            })
        });
    </script>
@endsection