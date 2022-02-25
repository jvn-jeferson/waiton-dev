@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">顧客の情報</h3>
                        <button id="submit_settings" class="btn btn-warning btn-block col-1 float-right" data-toggle="modal" data-target="#changeRegistrationInfoModal">変更・登録</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form class="various_settings">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-gray w-25">社名</th>
                                        <td class="w-50"><input type="text" name="name" id="name" value="{{$client->name}}" class="form-control" readonly/></td>
                                        <td>
                                            <div class="form-inline">
                                                <input type="radio" name="client_type" id="client_type" value="1" class="mx-auto my-auto" @if($client->business_type_id == 1) checked @endif disabled>法人
                                                <input type="radio" name="client_type" id="client_type" value="2" class="mx-auto my-auto" @if($client->business_type_id == 2) checked @endif disabled>個人
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">本店所在地</th>
                                        <td colspan="2"><input type="text" name="address" id="address" value="{{$client->address}}" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">代表者</th>
                                        <td colspan="2"><input type="text" name="representative" id="representative" value="{{$client->representative}}" class="form-control" readonly /></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">代表者住所</th>
                                        <td colspan="2"><input type="text" name="representative_address" id="representative_address" value="{{$client->representative_address}}" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">決算月</th>
                                        <td colspan="">
                                            <select name="final_accounts_month" id="final_accounts_month" class="col-2 form-control w-25" disabled>
                                                @foreach($months as $key => $month)
                                                     <option value="{{ $month }}" {{ $month == $client->tax_filing_month.'月' ? 'selected' : '' }}>{{ $month }}</option>
                                                @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">消費税の申告義務</th>
                                        <td colspan="2">
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="checkbox" id="data1" name="data1" value="課税事業者">
                                                    <label for="data1">課税事業者</label><br>
                                                </div>
                                                <div class="col-2">
                                                    (
                                                    <input type="checkbox" id="data2" name="data2" value="個別">
                                                    <label for="data1">個別</label><br>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="data3" name="data3" value="一括">
                                                    <label for="data1"> 一括</label><br><br>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="data4" name="data4" value="一括">
                                                    <label for="data1"> 一括 )</label><br><br>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="checkbox" id="data5" name="data5" value="免税事業者">
                                                    <label for="data1"> 免税事業者</label><br><br>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">国税庁識別番号</th>
                                        <td colspan="2"><input type="text" name="nta_num" id="nta_num" class="form-control" @if($client->credentials) value="{{$client->credentials->nta_id ?? ''}}" @endif readonly></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">パスワード</th>
                                        <td colspan="2"><input type="text" name="nta_pw" id="nta_pw" class="form-control" @if($client->credentials) value="{{$client->credentials->nta_password ?? ''}}" @endif readonly></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">E-tax納税者番号</th>
                                        <td colspan="2"><input type="text" name="el_tax_num" id="el_tax_num" class="form-control" @if($client->credentials) value="{{$client->credentials->el_tax_id ?? ''}}" @endif readonly></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">国税庁識別番号</th>
                                        <td colspan="2"><input type="text" name="el_tax_pw" id="el_tax_pw" class="form-control" @if($client->credentials) value="{{$client->credentials->el_tax_password ?? ''}}" @endif readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card card-dark card-outline">
                    <form action="{{route('new-client-user')}}" method="post">
                        @csrf
                        <input type="hidden" name="client_id" id="client_id" value="{{$client->id}}">
                        <div class="card-header">
                            <h3 class="card-title text-dark text-bold">
                                新規登録
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-gray w-25">
                                        <label for="" class="h4">
                                            <input type="radio" name="is_admin" id="is_admin" value="1"> 管理者
                                        </label>
                                    </th>
                                    <td class="w-25 text-center">名前</td>
                                    <td class="bg-gray">
                                        <input type="text" name="staff_name" id="staff_name" class="form-control">
                                        @error('staff_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-gray w-25">

                                        <label for="" class="h4">
                                            <input type="radio" name="is_admin" id="is_admin" value="0"> 利用者
                                        </label>
                                        @error('is_admin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </th>
                                    <td class="w-25 text-center">メールアドレス</td>
                                    <td class="bg-gray">
                                        <input type="text" name="staff_email" id="staff_email" class="form-control">
                                        @error('staff_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary float-right btn-submit" type="submit">登録</button>
                        </div>
                    </form>
                </div>
                <div class="card card-dark card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-bold text-dark">
                            ログイン情報
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td class="text-center"><button class="btn btn-warning" type="button" data-toggle="modal" data-target="#changeContactEmailModal">編集</button></td>
                                    <td class="w-25">ワンタイムパスワードの • 送付先メールアドレス</td>
                                    <td>{{$client->contact_email}}</td>
                                </tr>
                                @forelse($client->staffs as $staff)
                                    <tr class="bg-gray">
                                        <td colspan="3">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
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
                                        <td class="text-center">
                                            @if(Auth::user()->role_id == 2)
                                                <button class="btn btn-warning" role="button" onclick="updateUser({{$staff->id}})">編集</button>
                                            @endif
                                        </td>
                                        <th class="">
                                            名前
                                        </th>
                                        <td class="">
                                            {{$staff->name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if(Auth::user()->role_id == 2)
                                                <button class="btn btn-danger" onclick="deleteUser({{$staff->id}})">削除</button>
                                            @endif
                                        </td>
                                        <td>
                                            アクセスレベル
                                        </td>
                                        <td>
                                            @if($staff->is_admin == 0)
                                            利用者
                                            @else
                                            管理者
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                        </td>
                                        <td>
                                            メールアドレス
                                        </td>
                                        <td>
                                            {{$staff->user->email}}
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade " tabindex="-1" role="dialog" id="changeRegistrationInfoModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-bold">
                        顧客の情報
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="tabContent">
                        <li class="nav-item">
                            <a href="#registration_info" data-toggle="tab" class="nav-link active">Company Information</a>
                        </li>
                        <li class="nav-item">
                            <a href="#checkboxes" data-toggle="tab" class="nav-link">Notification Toggles</a>
                        </li>
                        <li class="nav-item">
                            <a href="#taxation_credentials" data-toggle="tab" class="nav-link">Taxation Credentials</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="registration_info">
                            <form action="{{route('update-client-info')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{$client->id}}">
                                <div class="p-3 table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-gray w-25">社名</th>
                                                <td>
                                                    <input type="text" name="name" id="name" class="form-control" value="{{$client->name}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">本店所在地</th>
                                                <td>
                                                    <input type="text" name="address" id="address" class="form-control" value="{{$client->address}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">代表者</th>
                                                <td>
                                                    <input type="text" name="representative" id="representative" class="form-control" value="{{$client->representative}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">代表者住所</th>
                                                <td>
                                                    <input type="text" name="representative_address" id="representative_address" class="form-control" value="{{$client->representative_address ?? ''}}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">決算月</th>
                                                <td>
                                                    <select name="tax_filing_month" id="tax_filing_month" class="form-control">
                                                        <option value="1">January</option>
                                                        <option value="2">Februrary</option>
                                                        <option value="3">March</option>
                                                        <option value="4">April</option>
                                                        <option value="5">May</option>
                                                        <option value="6">June</option>
                                                        <option value="7">July</option>
                                                        <option value="8">August</option>
                                                        <option value="9">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-success float-right">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="checkboxes">
                            <form action="" method="post">
                                <div class="p-3 table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-gray w-25">消費税の申告義務</th>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-light">
                                                            <input type="radio" name="is_taxable" id="option" value="1">
                                                            課税事業者
                                                        </label>
                                                        <label class="btn btn-light">
                                                            <input type="radio" name="is_taxable" id="option1" value="0">
                                                            免税事業者
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-success float-right">Submit</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="taxation_credentials">
                            <form action="{{route('update-client-credentials')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{$client->id}}">
                                <div class="p-3 table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-gray w-25">国税庁識別番号</th>
                                                <td>
                                                    <input type="text" name="nta_number" id="nta_number" class="form-control" @if($client->credentials) value="{{$client->credentials->nta_id ?? ''}}" @endif>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">パスワード</th>
                                                <td>
                                                    <input type="text" name="nta_password" id="nta_password" class="form-control" @if($client->credentials) value="{{$client->credentials->nta_password ?? ''}}" @endif>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">EL-tax納税者番号</th>
                                                <td>
                                                    <input type="text" name="el_tax_num" id="el_tax_num" class="form-control" @if($client->credentials) value="{{$client->credentials->el_tax_id ?? ''}}" @endif>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-gray w-25">国税庁識別番号</th>
                                                <td>
                                                    <input type="text" name="el_tax_password" id="el_tax_password" class="form-control" @if($client->credetials) value="{{$client->credentials->nta_password ?? ''}}" @endif>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-success float-right">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="changeContactEmailModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-bold">
                        送付先メールアドレス
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('change-contact-email')}}" method="post">
                        @csrf
                        <input type="hidden" name="client_id" id="client_id" value="{{$client->id}}" />
                        <div class="table-responsive">
                            <table class="table-bordered table">
                                <tr>
                                    <th>Email</th>
                                    <td class="bg-dark">
                                        <input type="email" name="contact_email" id="contact_email" value="{{$client->contact_email}}" class="form-control">
                                    </td>
                                    <td><button type="submit" class="btn btn-success btn-block">編集</button></td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal face" id="userModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Update User Information
                    </h4>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                </div>
                <form>
                    <input type="hidden" name="userID" id="userID">
                    <input type="hidden" name="clientID" id="clientID" value="{{$client->id}}">
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
                        <button class="float-right btn btn-primary" type="button" onclick="processUpdate()">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')

    <script>
        function deleteUser(id)
        {
            Swal.fire({
                title: "その後の動きは、変更しますか？",
                showCancelButton: true,
                focusConfirm: false
            }).then((result) => {
                if(result.isConfirmed) {
                    var url = "{{route('delete-user')}}"
                    axios.post(url, {
                        user_id : id
                    }).then(function(response) {
                        if(response.data == 'Deleted!')
                        {
                            Swal.fire({
                                title: 'Deleted',
                                icon: 'success'
                            }).then((result) => {
                                if(result.isConfirmed)
                                {
                                    location.reload()
                                }
                            })
                        }
                    }).catch(function(error) {
                        console.log(error.response.data)
                    })
                }
            })
        }

        function updateUser(user_id)
        {
            var url = "{{route('get-client-staff')}}"
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

        function processUpdate() {
            Swal.fire({
                title: "変更しますか？",
                showCancelButton: true,
                confirmButtonText: 'はい',
                cancelButtonText: 'いいえ',
                focusConfirm: false
            }).then((result) => {

                var laravelToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                var url = "{{route('update-client-staff')}}"

                axios.post(url, {
                    id: document.getElementById('userID').value,
                    name: document.getElementById('userName').value,
                    email: document.getElementById('userEmail').value,
                    password: document.getElementById('userPassword').value,
                }).then(function(response) {
                    if(response.data == 1)
                    {
                        Swal.fire({
                            title: "ユーザー情報が正常に変更されました。",
                            text: '更新されたログイン情報については、連絡先の電子メールを確認してください。',
                            icon: 'success',
                            showCancelButton: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if(result.isConfirmed)
                            {
                                location.reload()
                            }
                        })
                    }
                }).catch(function(error) {
                    console.log(error.response.data)
                })
            })
        }
    </script>
@endsection
