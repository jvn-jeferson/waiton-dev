@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-bold text-dark card-title">
                            ログイン
                        </h3>
                    </div>
                    <div class="card-body">
                        <h4 class="text-bold text-dark">
                            ログインパスワードの変更
                        </h3>
                        <h4 class="text-muted lead">
                            ログインパスワードを変更します。
                        </h4>
                        <div class="table-responsive mt-3">
                            <form action="{{route('change-existing-password')}}" method="post">
                                @csrf
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <th>ログインID（変更できません）</th>
                                        <th><input type="text" name="login_id" id="login_id" class="form-control" value="{{$login_id}}" readonly></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>送付されたパスワード</td>
                                            <td>
                                                <input type="password" name="temp_password" id="temp_password" class="form-control @error('temp_password') is-invalid @enderror" required>
                                                @error('temp_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>新パスワード</td>
                                            <td>
                                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>新パスワード（確認用）</td>
                                            <td>
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="submit" value="変更" class="btn btn-success btn-block col-2 float-right">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
