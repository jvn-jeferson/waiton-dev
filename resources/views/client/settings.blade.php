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
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">会社名</td>
                                <td class="text-bold">
                                    {{$account->name}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">当店の場所</td>
                                <td>
                                    {{$account->address}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">代表</td>
                                <td>
                                    {{$account->representative}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">代表住宅</td>
                                <td>
                                    {{$account->representative_address}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">連絡先メールアドレス</td>
                                <td class="text-primary">
                                    {{$account->contact_email}}
                                </td>
                            </tr>

                            @if (Auth::user()->role_id == 4)
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">NTA識別番号</td>
                                    <td>
                                        @if($account->credentials)
                                        {{$account->credentials->nta_id}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">パスワード</td>
                                    <td class="text-encrypted">

                                        @if($account->credentials)
                                        {{$account->credentials->nta_password}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">E-tax納税者番号</td>
                                    <td>

                                        @if($account->credentials)
                                        {{$account->credentials->el_tax_id}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold bg-lightblue w-25">パスワード</td>
                                    <td class="text-encrypted">

                                        @if($account->credentials)
                                        {{$account->credentials->el_tax_password}}
                                        @endif
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>

@if(Auth::user()->role_id == 4)
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
                    <form action="{{route('new-user')}}" method="POST">
                        @csrf
                        <input type="hidden" name="client_id" value="{{$account->id}}">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td class="bg-gray w-25">
                                    <label class="h4">ユーザータイプ</label>
                                    @error('staff_role')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </td>
                                <td>
                                    <label for="staff_role" class="h4">
                                        <input type="radio" name="staff_role" id="staff_role" class="p-1" value="1">  管理者
                                    </label>
                                </td>
                                <td>
                                    <label for="staff_role" class="h4">
                                        <input type="radio" name="staff_role" id="staff_role" class="p-1" value="0">  利用者
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-gray w-25">
                                    名前
                                    @error('staff_name')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </td>
                                <td colspan="2">
                                    <input type="text" name="staff_name" id="staff_name" class="form-control flat">
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-gray w-25 text-bold">
                                    メールアドレス
                                    @error('staff_email')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                </td>
                                <td colspan="2">
                                    <input type="email" name="staff_email" id="staff_email" class="form-control flat">
                                </td>
                            </tr>
                        </table>
                        <button class="col-2 btn btn-warning btn-block float-right" type="submit" name="submit">新規登録</button>
                    </form>
                    </div>
                </div>
            </div>

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
                            <tr>
                                <td colspan="3" class="bg-teal disabled"></td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    @if(auth()->user()->role_id == 4)<button class="btn btn-warning" data-toggle="modal" data-target="#contactEmailModal">編集</button>@endif
                                </td>
                                <td class="w-25 text-bold">
                                    ワンタイムパスワードの • 送付先メールアドレス
                                </td>
                                <td class="bg-gray">
                                    {{$account->contact_email}}
                                </td>
                            </tr>
                            @forelse($staffs as $staff)
                                <tr>
                                    <td colspan="3" class="bg-teal disabled"></td>
                                </tr>
                                <tr>
                                    <td class="text-center text-bold rowspan="2">
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
                                        {{$staff->user->login_id}}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>名前</td>
                                    <td>{{$staff->name}}</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if(auth()->user()->role_id == 4)
                                            <button class="btn btn-warning" role="button" onclick="editUser({{$staff->user->id}})">編集</button>
                                        @endif
                                    </td>
                                    <td>パスワード</td>
                                    <td class="bg-gray">**********</td>
                                </tr>
                                <tr>
                                    <td class="text-center">
                                        @if(auth()->user()->role_id == 4)
                                            <button class="btn btn-danger" role="button" onclick="deleteStaff({{$staff->id}})">削除</button>
                                        @endif
                                    </td>
                                    <td>メールアドレス</td>
                                    <td class="bg-gray">{{$staff->user->email}}</td>
                                </tr>
                            @empty

                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

            @endif
        </section>
    </div>

    <div class="modal fade" id="contactEmailModal" tabindex="-1" aria-labelledby="contactEmailModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactEmailModalLabel">送付先メールアドレス</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <form action="{{route('update-contact-email-client')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$account->id}}">
                            <table class="table table-bordered">
                                <thead>
                                    <th>
                                        <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{$account->contact_email}}">
                                    </th>
                                    <th>
                                        <button class="btn btn-block btn-warning" type="submit">編集</button>
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
                <form action="{{route('update-staff-client')}}" method="post">
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
    $(function() {
        $('form').submit(function(e) {
            Swal.showLoading()
        })
    })

    function editUser(user_id)
        {
            var url = "{{route('get-user-client')}}";
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
                    var url = "{{route('delete-ca-staff')}}"

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
    
</script>
@endsection
