@extends('layouts.app')

@section('content')
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{asset('img/signin-image.jpg')}}" alt="sing up image"></figure>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                    <div class="signin-form">
                        <h2 class="form-title">ログイン</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="email_address"><i class="zmdi zmdi-email material-icons-name"></i></label>
                                <input id="email" type="email" placeholder="ID" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input id="password" type="password" placeholder="パスワード" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>私を覚えてますか</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="ログイン"/>
                            </div>
                      
                            </div>
                        </form>
                    </div>
                    </form>
                </div>
            </div>
    </div>
@endsection
