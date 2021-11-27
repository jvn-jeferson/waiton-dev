@extends('layouts.app')
@section('content')
<div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">登録を完了します</h2>
                        <form method="POST" action="{{ route('registration') }}" id="payment_start">
                            @csrf
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-home material-icons-name"></i></label>
                                <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="事務所名" required/>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <input type="hidden" name="subscription_plan" id="subscription_plan" value="{{$data['id']}}" > --}}
                            <div class="form-group">
                                <label for="representative"><i class="zmdi zmdi-account"></i></label>
                                <input type="text" class="@error('representative') is-invalid @enderror" name="representative" id="representative"  value="{{ old('representative') }}" placeholder="代表者"/>
                                @error('representative')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="address"><i class="zmdi zmdi-nature-people"></i></label>
                                <input type="text" class="@error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address') }}" autocomplete="address"  placeholder="所在地"/>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telephone"><i class="zmdi zmdi-local-phone"></i></label>
                                <input type="text" class="@error('telephone') is-invalid @enderror" name="telephone" id="telephone" value="{{ old('telephone') }}" placeholder="電話番号"/>
                                @error('telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" class="@error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="電子メイル"/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <!-- <div class="form-group">
                                <label for="contact_email"><i class="zmdi zmdi-email"></i></label>
                                <input id="contact_email" type="email" class="@error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email') }}" autocomplete="email" placeholder="メールアドレス">

                                @error('contact_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> -->
                            <div class="form-group">
                                <input type="checkbox" class="@error('agree-term') is-invalid @enderror" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>私はのすべての声明に同意します <a href="#" class="term-service text-info">利用規約</a></label>
                                @error('agree-term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Please accept our terms and conditions to continue.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" value="登録" class="btn btn-success btn-block">
                            </div>
                            {{-- <div class="form-group form-button">
                                <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_51IShqvDBrLv03ZFnYLiidxC5jiBlzh9EXwlwPeO54cUtCJrgBnicvipCHNaxCbxgyYDG6ecn5kQcznAQfte5qo7C00HAac3a3r"
                                data-amount="{{$data['price']}}"
                                data-name="{{$data['name']}}"
                                data-description="Plan"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto"
                                data-label="チェックアウトに進む"
                                data-currency="jpy"
                                >
                                </script>
                                <input type="hidden" name="amount" value="{{$data['price']}}">
                            </div> --}}
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="{{asset('img/signup-image.jpg')}}" alt="sing up image"></figure>
                    </div>
                </div>
            </div>

@endsection
