@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-dark text-bold">顧客の情報</h3>
                        <button class="btn btn-warning btn-block col-1 float-right">変更・登録</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-gray w-25">社名</th>
                                        <td class="w-50"><input type="text" name="name" id="name" value="{{$client->name}}" class="form-control" readonly/></td>
                                        <td>
                                            <div class="form-inline">

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">本店所在地</th>
                                        <td colspan="2"><input type="text" name="address" id="address" value="{{$client->address}}" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">代表者</th>
                                        <td colspan="2"><input type="text" name="representative" id="representative" value="{{$client->representative}}" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">代表者住所</th>
                                        <td colspan="2"><input type="text" name="representative_address" id="representative_address" value="{{$client->representative_address}}" class="form-control" readonly/></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">決算月</th>
                                        <td colspan="2">
                                            <select name="final_accounts_month" id="final_accounts_month" class="col-1 form-control">
                                                <option value="1">1月</option>
                                                <option value="2">2月</option>
                                                <option value="3">3月</option>
                                                <option value="4">4月</option>
                                                <option value="5">5月</option>
                                                <option value="6">6月</option>
                                                <option value="7">7月</option>
                                                <option value="8">8月</option>
                                                <option value="9">9月</option>
                                                <option value="10">10月</option>
                                                <option value="11">11月</option>
                                                <option value="12">12月</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="bg-gray w-25">消費税の申告義務</th>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">国税庁識別番号</th>
                                        <td colspan="2"><input type="text" name="nta_num" id="nta_num" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">パスワード</th>
                                        <td colspan="2"><input type="text" name="nta_pw" id="nta_pw" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">E-tax納税者番号</th>
                                        <td colspan="2"><input type="text" name="el_tax_num" id="el_tax_num" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-gray w-25">国税庁識別番号</th>
                                        <td colspan="2"><input type="text" name="el_tax_pw" id="el_tax_pw" class="form-control"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card card-dark card-outline">
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
                                        <input type="radio" name="is_admin" id="is_admin" value="0"> 利用者 
                                    </label>
                                </th>
                                <td class="w-25 text-center">名前</td>
                                <td class="bg-gray">
                                    <input type="text" name="" id="staff_name" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-gray w-25">
                                    <label for="" class="h4">
                                        <input type="radio" name="is_admin" id="is_admin" value="1"> 管理者 
                                    </label>
                                </th>
                                <td class="w-25 text-center">メールアドレス</td>
                                <td class="bg-gray">
                                    <input type="text" name="staff_email" id="staff_email" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </div>
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
                                    <td class="text-center"><button class="btn btn-warning">編集</button></td>
                                    <td class="w-25">ワンタイムパスワードの • 送付先メールアドレス</td>
                                    <td>{{$client->contact_email}}</td>
                                </tr>
                                @forelse($client->staffs as $staff)
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
                                            @if($staff->is_admin == 1)
                                                <button class="btn btn-warning">編集</button>
                                            @endif
                                        </td>
                                        <td>
                                            名前
                                        </td>
                                        <td>
                                            {{$staff->name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            @if($staff->is_admin == 1)
                                                <button class="btn btn-danger">削除</button>
                                            @endif
                                        </td>
                                        <td>
                                            パスワード
                                        </td>
                                        <td>
                                            ************
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
@endsection

@section('extra-scripts')
@endsection