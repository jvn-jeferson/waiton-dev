@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="form-title">新規登録</h2>
            <form method="POST" action="{{ route('update-credentials') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <h4 class="lead my-2">メールに記載されたIDを入力してください。</h4>
                <div class="form-group">
                    <input type="text" name="login_id" id="login_id" placeholder="ID" value="{{ old('login_id') }}" class="form-control @error('login_id') is-invalid @enderror" />
                    @error('login_id')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

                <h4 class="lead my-4">パスワードを変更してログインしてください。</h4>
                <div class="form-group">
                    <input type="password" name="current_password" id="current_password" placeholder="送付されたパスワード" value="{{ old('current_password') }}" class="form-control @error('current_password') is-invalid @enderror">
                    @error('current_password')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="新しいパスワード" class="form-control @error('password') is-invalid @enderror"/>
                    @error('password')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="新しいパスワード（確認用）" class="form-control @error('password_confirmation') is-invalid @enderror"/>
                    @error('password_confirmation')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-3">
                        <input type="submit" value="登録" class="btn btn-primary">
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
    @endsection
