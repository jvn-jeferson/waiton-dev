@extends('layouts.app')

@section('content')
<div class="container p-5">
    <div class="card">
        <div class="card-header text-center">
            <h3 class="card-title">ログイン</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('login')}}" method="POST">
                @csrf
                <h3 class="lead my-2 text-center">
                    
                </h3>
                    <div class="form-group">
                        <label for="email_address"><i class="zmdi zmdi-email material-icons-name"></i></label>
                        <input id="login_id" type="text" placeholder="ID" class="@error('login_id') is-invalid @enderror" name="login_id" value="{{ old('login_id') }}" required autocomplete="email" autofocus>
    
                        @error('login_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="zmdi zmdi-lock"></i></label>
                        <input id="password" type="password" placeholder="パスワード" class="@error('password') is-invalid @enderror" name="password" required autocomplete="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group form-button">
                        <input type="submit" name="signin" id="signin" class="form-submit" value="ログイン"/>
                    </div>
            </form>
            <h3 class="lead mt-5 text-dark">
                パスワードをお忘れの方
            </h3>
            <h4 class="lead mt-2">
                １　利用者は会計事務所の管理者にご連絡いただき、管理者の管理画面からパスワードの修正を行ってください。
            </h4>
            <h4 class="lead mt-2">
                ２　管理者のパスワードが不明な場合は<strong class="text-bold"><a href="{{route('forgot-password')}}" class="text-info">こちら</a></strong>から手続きしてください。
            </h4>
        </div>
    </div>
</div>
@endsection
