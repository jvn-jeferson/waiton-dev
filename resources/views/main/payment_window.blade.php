@extends('layouts.app')

@section('extras')

@endsection

@section('content')

    <div class="container">
        <div class="col-lg-12 p-2">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">購入を確認します</h1>
                <p class="lead">お支払い情報を入力して購入を確認します。 お支払いが完了すると、登録ページにリダイレクトされます。</p>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-8 p-3">
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    {{-- <form action="{{route('pay-for-sub')}}" method="post" 
                                    data-cc-on-file="false" 
                                    data-stripe-publishable-key="{{env('STRIPE_KEY')}}" 
                                    data-name="{{$data['name']}}"
                                    data-representative="{{$data['representative']}}"
                                    data-address="{{$data['tel_number']}}"
                                    data-email="{{$data['email']}}"
                                    data-subscription_plan_id="{{$data['subscription_plan_id']}}"
                                    data-temporary_password="{{$data['temporary_password']}}"
                                    id="payment-form">
                        @csrf
                        <h4 class="text-justify mx-auto">
                            注文詳細
                        </h4>
                        <input type="hidden" name="name" id="name" value="{{$data['name']}}">
                        <input type="hidden" name="representative" id="representative"  value="{{$data['representative']}}">
                        <input type="hidden" name="tel_number" id="tel_number"  value="{{$data['tel_number']}}">
                        <input type="hidden" name="email" id="email"  value="{{$data['email']}}">
                        <input type="hidden" name="address" id="address" value="{{$data['address']}}">
                        <input type="hidden" name="subscription_plan_id" id="subscription_plan_id"  value="{{$data['subscription_plan_id']}}">
                        <input type="hidden" name="temporary_password" id="temporary_password"  value="{{$data['temporary_password']}}">
                    
                        <div class="form-group">
                            <p class="lead"><strong class="text-dark">アカウント名: </strong> {{ $data['name']}}</p>
                            <p class="lead"><strong class="text-dark">電子メールアドレス: </strong> {{$data['email']}}</p>
                            <p class="lead"><strong class="text-dark">合計金額: </strong><span class="text-success">2000 ¥</span></p>
                        </div>

                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none">
                            
                        </div>
                        <h4 class="mx-auto text-justify">課金情報</h4>
                        <div class="form-group">
                            <label for="cardholder"><i class="zmdi zmdi-account"></i></label>
                            <input type="text" class="@error('cardholder') is-invalid @enderror required" name="cardholder" id="cardholder"  value="{{ old('cardholder') }}" autocomplete="cardholder" placeholder="カード所有者の名前"/>
                            @error('cardholder')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="billing_address"><i class="zmdi zmdi-home"></i></label>
                            <input type="text" class="@error('billing_address') is-invalid @enderror required" name="billing_address" id="billing_address"  value="{{ old('billing_address') }}" autocomplete="billing_address" placeholder="カード所有者の名前"/>
                            @error('billing_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="card-number"><i class="zmdi zmdi-card"></i></label>
                            <input type="number" name="card-number" id="card-number" placeholder="xxxx xxxx xxxx xxxx" class="required">
                        </div>
                        <div class="row form-row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label for="card-expiry"><i class="zmdi zmdi-calendar"></i></label>
                                    <input type="text" name="card-expiry" id="card-expiry" placeholder="Expiry date" class="required">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label for="card-cvc"><i class="zmdi zmdi-calendar"></i></label>
                                    <input type="text" name="card-cvc" id="card-cvc" placeholder="CVC" class="required">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-sumbit btn-success btn-block" type="submit">Pay ($120.00)</button>
                        </div>
                    </form> --}}

                    <form action="{{route('payment_process')}}" id="stripe" method="post">
                        @csrf
                        <input type="hidden" name="email" id="email" value="{{$data['email']}}">
                        <input type="hidden" name="name" id="name" value="{{$data['name']}}">
                        <input type="hidden" name="representative" id="representative" value="{{$data['representative']}}">
                        <input type="hidden" name="temporary_password" id="temporary_password" value="{{$data['temporary_password']}}">
                        <input type="hidden" name="address" id="address" value="{{$data['address']}}">
                        <input type="hidden" name="tel_number" id="tel_number" value="{{$data['telephone']}}">
                        <input type="hidden" name="subscription_plan_id" id="subscription_plan_id" value="{{$data['subscription_plan_id']}}">

                        <p class="lead text-bold">課金情報</p>
                        <div class="form-group">
                            <label for="cardholder"><i class="zmdi zmdi-account"></i></label>
                            <input type="text" class="" name="cardholder" id="cardholder"  value="{{ old('cardholder') }}" autocomplete="cardholder" placeholder="カード所有者の名前"/>
                        </div>
                        <div class="form-group">
                            <label for="address_line_1"><i class="zmdi zmdi-nature-people"></i></label>
                            <input type="text" class="" name="address_line_1" id="address_line_1"  value="{{ old('address_line_1') }}" autocomplete="address_line_1" placeholder="住所1"/>
                        </div>
                        <div class="form-group form-row">
                            <input type="text" class="col-4" name="city" id="city" value="{{ old('city') }}" autocomplete="city" placeholder="都市">
                            <input type="text" class="col-4 ml-auto" name="province" id="province" value="{{ old('province') }}" autocomplete="province" placeholder="州">
                            <input type="text" class="col-3 ml-auto" name="area_code" id="area_code" value="{{ old('area_code') }}" autocomplete="area_code" placeholder="市外局番">
                        </div>
                        <p class="lead text-bold mt-1">カードの詳細</p>
                        <div id="card-elements" class="mt-2"></div>
                        <input type="hidden" id="pmethod" name="pmethod" value="">
                        <button id="card-button" class="btn btn-primary mt-5">
                            Process Payment
                        </button>
                    </form>

                </div>
                <div class="col-md-4 p-3">
                    <h3 class="mx-auto text-justify">あなたは<strong class="text-info">{{$plan['name']}}</strong>のプランを選択しました。</h3>
                    <p class="lead">月額<strong class="text-dark">{{$plan['price']}}</strong> 毎年請求されます。 合計料金：<strong class="text-success">¥ {{$plan['price']*12}}</strong> </p>
                    <p class="lead">これには、次の機能が含まれます:</p>

                    <ul class="list-unstyled">
                        <li>Upto <strong class="text-primary">{{$plan['max_clients']}}</strong> clients</li>
                        <li><strong class="text-primary">{{$plan['max_storage']}}GB</strong> Storage available</li>
                        <li>Upto <strong class="text-primary">{{$plan['max_admin']}}</strong> account administrators</li>
                        <li>Upto <strong class="text-primary">{{$plan['max_admin']}}</strong> account users</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
  const stripe = Stripe("{{env('STRIPE_KEY')}}");
  
  const elements = stripe.elements();
  const cardElement = elements.create('card');

  cardElement.mount('#card-elements');

  const cardHoldersName = document.getElementById('cardholder');
  const form = document.createElement('stripe');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const { paymentMethod, error } = await stripe.createPaymentMethod(
        'card', cardElement, {
            billing_details: {
                name: cardHoldersName, value
            }
        }
    )
    if (error) {
        console.log(error);
    } else {
        console.log('Card verified successfully');
        console.log(paymentMethod.id);
        document.getElementById('payment-method').setAttribute('value', paymentMethod.id);
        form.submit();
    }
  });


</script>

<script>
    $(document).ready(function() {
        console.log();
    })
</script>

@endsection