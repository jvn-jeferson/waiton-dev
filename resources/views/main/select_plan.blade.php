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
                    <div class="card mb-4 box-shadow mt-4 text-center">
                      <div class="card-header">
                        <h4 class="my-0 font-weight-normal">基本</h4>
                      </div>
                      <div class="card-body">
                        <h1 class="card-title pricing-card-title">$10 <small class="text-muted">/ mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                          <li>10 users included</li>
                          <li>2 GB of storage</li>
                          <li>Email support</li>
                          <li>Help center access</li>
                        </ul>
                        <a class="btn btn-lg btn-block btn-primary" href="confirm-payment">Choose</a>
                      </div>
                    </div>
                    <div class="card mb-4 box-shadow mt-1 text-center">
                        <div class="bg-success">
                            <h4 class="my-0">Best Plan</h4>
                        </div>
                      <div class="card-header">
                        <h4 class="my-0 font-weight-normal">ベーシックプラス</h4>
                      </div>
                      <div class="card-body justify-contents-center">
                        <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                          <li>20 users included</li>
                          <li>10 GB of storage</li>
                          <li>Priority email support</li>
                          <li>Help center access</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-success">Choose</button>
                      </div>
                    </div>
                    <div class="card mb-4 box-shadow mt-4 text-center">
                      <div class="card-header">
                        <h4 class="my-0 font-weight-normal">企業</h4>
                      </div>
                      <div class="card-body">
                        <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                          <li>30 users included</li>
                          <li>15 GB of storage</li>
                          <li>Phone and email support</li>
                          <li>Help center access</li>
                        </ul>
                        <button type="button" class="btn btn-lg btn-block btn-primary">Choose</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection