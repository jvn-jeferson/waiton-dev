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
                                        <button class="btn btn-warning btn-tool text-light" data-toggle="modal" data-target="#updateModal" id="btn-swal">変更・登録</button>
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
                                                <td>{{$account->clients->count()}} 社 | {{$account->staff->count()}} ユーザー</td>
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
                @if(Auth::user()->role_id == 2)
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
                                                        <td class="text-bold">
                                                            ユーザータイプ
                                                        </td>
                                                        <td>
                                                            <label for="" class="h3">
                                                                <input type="radio" name="is_admin" id="is_admin" value="1">管理者
                                                            </label>
                                                        </td>
                                                        <td class="text-bold">
                                                            <label for="" class="h3">
                                                                <input type="radio" name="is_admin" id="is_admin" value="0">利用者
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-bold">名前</td>
                                                        <td class="bg-light" colspan="2"><input type="text" name="name" id="name" class="form-control bg-light"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>メールアドレス</td>
                                                        <td class="bg-light" colspan="2"><input type="email" name="email" id="email" class="form-control bg-light"></td>
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
                                                    <button class="btn btn-warning" role="button" data-toggle="modal" data-target="#contactEmailModal">編集</button>
                                                </td>
                                                <td class="text-left">
                                                    ワンタイムパスワードの•送付先メールアドレス
                                                </td>
                                                <td>
                                                    <input type="email" name="destination_email" id="destination_email" class="form-control" value="{{$account->contact_email}}" readonly>
                                                </td>
                                            </tr>
                                            @forelse($staffs as $staff)
                                                <tr class="bg-light">
                                                    <td colspan="3"></td>
                                                </tr>
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
                                                        <button class="btn btn-warning" role="button" data-toggle="tooltip" data-placement="top" data-tooltip="Edit" onclick="editUser({{$staff->user->id}})">編集</button>
                                                    </td>
                                                    <td>ユーザーID</td>
                                                    <td>
                                                        <input type="text" name="user_id" id="user_id" class="form-control" value="{{$staff->user->login_id}}" readonly>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger" role="button" data-toggle="tooltip" data-placement="top" data-tooltip="Delete" onclick="deleteStaff({{$staff->id}})">削除</button>
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
                @endif
            </div>
        </section>
    </div>

    <div id="updateModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Registration</h4>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('update-registration-info')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>事務所名</th>
                                    <td><input type="text" class="form-control" value="{{$account->name}}" name="name" id="name"></td>
                                </tr>
                                <tr>
                                    <th>代表者</th>
                                    <td><input type="text" class="form-control" value="{{$account->representative}}" name="representative" id="representative"></td>
                                </tr>
                                <tr>
                                    <th>所在地</th>
                                    <td><input type="text" class="form-control" value="{{$account->address}}" name="address" id="address"></td>
                                </tr>
                                <tr>
                                    <th>電話番号</th>
                                    <td><input type="text" class="form-control" value="{{$account->telephone}}" name="telephone" id="telephone"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary float-right" type="submit">変更</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contactEmailModal" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        ワンタイムパスワードの•送付先メールアドレス
                    </h4>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form action="{{route('update-otp-email')}}" method="post">
                            @csrf
                            <input type="hidden" name="accountingOfficeID" value="{{$account->id}}">
                            <table class="table table-bordered">
                                <thead>
                                    <th>
                                        <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{$account->contact_email}}">
                                    </th>
                                    <th>
                                        <button class="btn btn-block btn-warning" type="submit">Update</button>
                                    </th>
                                </thead>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Update User Information
                    </h4>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{route('update-staff')}}" method="post">
                    <input type="hidden" name="userID" id="userID">
                    @csrf
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>
                                            名前
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" id="userName" name="userName">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            メールアドレス
                                        </th>
                                        <td>
                                            <input type="email" class="form-control" id="userEmail" name="userEmail">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            ユーザーID
                                        </th>
                                        <td>
                                            <input type="text" class="form-control" id="userLogin" name="userLogin" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>New Password</th>
                                        <td>
                                            <input type="password" name="userPassword" id="userPassword" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="float-right btn btn-primary" type="submit">変更</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script>
        //create new user
        $("#newUserForm").on('submit', function(event) {
            event.preventDefault()
            var url = "{{route('register-new-staff')}}"
            var is_admin_check = $('#is_admin:checked').val()
            axios.post(url, {
                is_admin : is_admin_check,
                name: $('#name').val(),
                email: $('#email').val()
            }).then(function(response) {

                Swal.fire({
                    title: 'ユーザーの作成に成功',
                    icon: 'success',
                }).then((result) => {
                   if(result.isConfirmed) {
                    $('#name').val('')
                    $('#email').val('')
                    $('#is_admin').checked = false
                   }
                })
                window.location.reload()
            }).catch(function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Check your inputs and try again.',
                })
            })
        });

        //update user
        function editUser(user_id)
        {
            var url = "{{route('get-user')}}";
            var name, email;
            var userModal = $('#userModal');
            axios.post(url, {
                id: user_id,
            }).then(function(response) {
                name = response.data['name']
                email = response.data['email']
                id = response.data['id']
                login_id = response.data['login_id']
                remember_token = response.data['token']

                $('#userName').val(name)
                $('#userEmail').val(email)
                $('#userLogin').val(login_id)
                $('#userID').val(id)
                userModal.modal('show');

            }).catch(function(error) {
                console.log(error.response.data)
            })
        }

        //delete user
        function deleteStaff(staff_id)
        {
            Swal.fire({
                title: '本当に削除しますか？',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'キャンセル',
                preConfirm: function() {
                    var url = "{{route('delete-ao-staff')}}"

                    return axios.post(url, {
                        id : staff_id
                    }).then(function(response) {

                    }).catch(function(error) {
                        console.log(error.response.data)
                        return false
                    })
                },
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading()
            }).then(() => {
                Swal.fire({
                            title: '削除完了しました。',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000,
                            allowOutsideClick: false
                        }).then((result) => {
                            if(result.dismiss == Swal.DismissReason.timer){
                                location.reload()
                            }
                        })
            })


        }

        $(function() {
            $('form').submit(function(e) {
                Swal.showLoading()
            })
        })
    </script>
@endsection
