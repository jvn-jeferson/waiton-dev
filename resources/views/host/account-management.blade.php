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
                                                <td>
                                                    @if($account->subscription)
                                                        有料会員
                                                    @else
                                                        無料ユーザー
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>選択プラン</td>
                                                <td>
                                                    @if($account->subscription)
                                                        {{$account->subscription->subscription_plan->name}}
                                                    @else
                                                        {{""}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>利用者数</td>
                                                <td>{{$account->staff->count()}} 社</td>
                                            </tr>
                                            <tr>
                                                <td>ご利用期日</td>
                                                <td>
                                                    @if($account->subscription)
                                                        {{$account->subscription->created_at->format('Y/m/d') .'~'. $account->subscription->ends_at->format('Y/m/d')}}
                                                    @else
                                                    @endif
                                                    • {{$account->created_at}}</td>
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
                                                <td class="text-center">
                                                    <button class="btn btn-warning" role="button" data-toggle="tooltip" data-placement="top" data-tooltip="Edit">編集</button>
                                                </td>
                                                <td class="text-left">
                                                    ワンタイムパスワードの•送付先メールアドレス
                                                </td>
                                                <td>
                                                    <input type="email" name="destination_email" id="destination_email" class="form-control" value="{{$account->contact_email}}" readonly>
                                                </td>
                                            </tr>
                                            @forelse($staffs as $staff)
                                                <tr>
                                                    <td class="text-center" rowspan="2">
                                                        @if($staff->is_admin == 1)
                                                            管理者
                                                        @else
                                                            利用者
                                                        @endif
                                                    </td>
                                                    <td>
                                                        ID
                                                    </td>
                                                    <td>
                                                        {{$staff->user->id}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>名前</td>
                                                    <td>
                                                        <input type="text" name="staff_name" id="staff_name" class="form-control" value="{{$staff->name}}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <button class="btn btn-warning" role="button" data-toggle="tooltip" data-placement="top" data-tooltip="Edit">編集</button>
                                                    </td>
                                                    <td>パスワード</td>
                                                    <td>
                                                        <input type="password" name="password" id="password" class="form-control" value="**********" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger" role="button" data-toggle="tooltip" data-placement="top" data-tooltip="Delete">削除</button>
                                                    </td>
                                                    <td>メールアドレス</td>
                                                    <td>
                                                        <input type="email" name="email" id="email" class="form-control" value="{{$staff->user->email}}" readonly>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-danger">登録ユーザーのリストを取得できませんでした。</td>
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