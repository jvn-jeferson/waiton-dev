@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="form-title">自分のパスワードを設定します。</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <h4 class="lead my-2">Eメール</h4>
                <div class="form-group">
                    <label for="new_password"><i class="zmdi zmdi-email"></i></label>
                    <input type="email" name="email" id="email" readonly placeholder="新しいパスワード" value="{{ $email ?? old('email') }}" readonly />
                </div>

                <h4 class="lead my-2">新しいパスワード</h4>
                <div class="form-group">
                    <label for="password"><i class="zmdi zmdi-lock"></i></label>
                    <input type="password" name="password" id="password" placeholder="新しいパスワード" required/>
                </div>

                <h4 class="lead my-2">パスワードを認証する</h4>
                <div class="form-group">
                    <label for="password_confirmation"><i class="zmdi zmdi-lock"></i></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="パスワードを再入力してください" />
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
    @endsection
