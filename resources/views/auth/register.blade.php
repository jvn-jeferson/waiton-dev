@extends('layouts.app')

@section('content')
<div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">新規申込（会計事務所）</h2>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-face material-icons-name"></i></label>
                                <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="事務所名"/>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="representative"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" name="representative" id="representative" placeholder="代表者"/>
                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-nature-people"></i></label>
                                <input type="text" name="address" id="address" placeholder="所在地"/>
                            </div>
                            <div class="form-group">
                                <label for="tel_number"><i class="zmdi zmdi-local-phone"></i></label>
                                <input type="number" name="tel_number" id="tel_number" placeholder="電話番号"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="メールアドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-key"></i></label>
                            <input id="password" type="password" placeholder="パスワード" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>私はのすべての声明に同意します <a href="#" class="term-service">利用規約</a></label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="登録"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{asset('img/signup-image.jpg')}}" alt="sing up image"></figure>
                    </div>
                </div>
            </div>
@endsection
