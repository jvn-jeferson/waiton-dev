@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="form-title">新規登録</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <h4 class="lead my-2">メールに記載されたIDを入力してください。</h4>
                <div class="form-group">
                    <label for="new_password"><i class="zmdi zmdi-email"></i></label>
                    <input type="email" name="email" id="email" readonly placeholder="新しいパスワード" value="{{ $email ?? old('email') }}" readonly />
                </div>

                <h4 class="lead my-4">パスワードを変更してログインしてください。</h4>
                <div class="form-group">
                    <label for="temp"><i class="zmdi zmdi-lock-open"></i></label>
                    <input type="text" name="temp" id="temp" placeholder="送付されたパスワード">
                </div>
                <div class="form-group">
                    <label for="password"><i class="zmdi zmdi-lock"></i></label>
                    <input type="password" name="password" id="password" placeholder="新パスワード" required/>
                </div>
                <div class="form-group">
                    <label for="password_confirmation"><i class="zmdi zmdi-lock"></i></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="新パスワード（確認用）" />
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-3">
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
