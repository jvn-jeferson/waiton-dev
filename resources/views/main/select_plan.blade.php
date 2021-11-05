@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 p-3">
                <div class="container">

                <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                    <h1 class="display-4">サブスクリプションの計画</h1>
                    <p class="lead">ビジネスモデルに最適なプランを選択してください。</p>
                </div>

                <div class="card-deck mb-3">
                  @foreach($plans as $plan)
                    <div class="card mb-4 box-shadow @if($plan['name']=='Intermediate') mt-1 @else mt-4 @endif text-center">
                      @if($plan['name']=='Intermediate')
                        <div class="bg-success">
                          <h4 class="my-0">Most Recommended</h4>
                        </div>
                      @endif
                      <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{$plan['name']}}</h4>
                      </div>
                      <div class="card-body">
                        <h1 class="pricing-card-title">{{$plan['price']}} ¥<small class="text-muted">/month</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                          <li>Upto <strong class="text-primary">{{$plan['max_clients']}}</strong> clients</li>
                          <li><strong class="text-primary">{{$plan['max_storage']}}GB</strong> Storage available</li>
                          <li>Upto <strong class="text-primary">{{$plan['max_admin']}}</strong> account administrators</li>
                          <li>Upto <strong class="text-primary">{{$plan['max_admin']}}</strong> account users</li>
                        </ul>

                        <a href="registration/{{strtolower($plan['id'])}}" class="btn @if($plan['name']=='Intermediate') btn-success @else btn-primary @endif">Choose</a>
                      </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

