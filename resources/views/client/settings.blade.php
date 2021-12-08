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
                            <tr>
                                <td class="text-bold bg-lightblue w-25">NTA識別番号</td>
                                <td>
                                    {{'' ??$account->credentials->nta_id}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">パスワード</td>
                                <td class="text-encrypted">
                                    {{'' ??$account->credentials->nta_password}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">E-tax納税者番号</td>
                                <td>
                                    {{'' ??$account->credentials->el_tax_id}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-bold bg-lightblue w-25">パスワード</td>
                                <td class="text-encrypted">
                                    {{'' ??$account->credentials->el_tax_password}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td class="bg-gray w-25">
                                    <label for="staff_role" class="h4">
                                        <input type="radio" name="staff_role" id="staff_role" class="p-1" value="1">  利用者
                                    </label>
                                </td>
                                <td class="text-bold text-dark w-25">
                                    名前
                                </td>
                                <td class="bg-gray">
                                    <input type="text" name="staff_name" id="staff_name" class="form-control flat">
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-gray w-25">
                                    <label for="staff_role" class="h4">
                                        <input type="radio" name="staff_role" id="staff_role" class="p-1" value="0">  管理者
                                    </label>
                                </td>
                                <td class="text-bold text-dark w-25">
                                    メールアドレス
                                </td>
                                <td class="bg-gray">
                                    <input type="email" name="staff_email" id="staff_email" class="form-control flat">
                                </td>
                            </tr>
                        </table>
                        <button class="col-2 btn btn-warning btn-block float-right" type="submit" name="submit">新規登録</button>
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
                                <td class="text-center">
                                    <button class="btn btn-warning">編集</button>
                                </td>
                                <td class="text-center w-25">
                                    ワンタイムパスワードの • 送付先メールアドレス
                                </td>
                                <td class="bg-gray">
                                    {{$account->contact_email}}
                                </td>
                            </tr>
                            @forelse($staffs as $staff)
                                <tr>
                                    <td class="text-center text-bold @if($staff->is_admin == 0) bg-gray @endif">
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
                                    <td class="@if($staff->is_admin == 0) bg-gray @endif text-center">
                                        @if($staff->is_admin == 1)
                                            <button class="btn btn-warning">編集</button>
                                        @endif
                                    </td>
                                    <td>名前</td>
                                    <td>{{$staff->name}}</td>
                                </tr>
                                <tr>
                                    <td class="@if($staff->is_admin == 0) bg-gray @endif) text-center">
                                        @if($staff->is_admin == 0 && auth()->user->role_id == 4)
                                            <button class="btn btn-danger">削除</button>
                                        @endif
                                    </td>
                                    <td>パスワード</td>
                                    <td class="bg-gray">**********</td>
                                </tr>
                                <tr>
                                    <td class="@if($staff->is_admin == 0) bg-gray @endif"></td>
                                    <td>メールアドレス</td>
                                    <td class="bg-gray">{{$staff->user->email}}</td>
                                </tr>
                            @empty

                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



@section('extra-scripts')
@endsection