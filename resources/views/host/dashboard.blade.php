@extends('layouts.host')

@section('content')
  <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1">
                <i class="fas fa-cog"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Current Plan</span>
                <span class="info-box-number">
                  @if(Auth::user()->accountingOffice->subscription)
                  {{Auth::user()->accountingOffice->subscription->subscription_plan->name}}
                  @else
                    FREE USER
                  @endif
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-success elevation-1">
                <i class="fas fa-hdd"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Storage Usage</span>
                <span class="info-box-number">
                  10 <small>%</small>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1">
                <i class="fas fa-users"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Clients</span>
                <span class="info-box-number">
                  {{Auth::user()->accountingOffice->clients->count()}} / @if(Auth::user()->accountingOffice->subscription) {{ Auth::user()->accountingOffice->subscription->subscription_plan->max_clients}} @else 1 @endif
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-danger elevation-1">
                <i class="fas fa-tasks"></i>
              </span>
              <div class="info-box-content">
                <span class="info-box-text">Tasks</span>
                <span class="info-box-number">
                  10 <small>%</small>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 col-sm-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title text-white">
                  今月の決算
                </h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table-hover table table-striped table-bordered text-center">
                    <thead class="thead bg-info">
                      <th>事業者名</th>
                      <th>決算月</th>
                      <th>提出月</th>
                      <th>種類</th>
                    </thead>
                    <tbody>
                      {{-- @foreach($companies as $company) --}}
  
                      @forelse(Auth::user()->accountingOffice->clients as $client)
                        <tr>
                          <td>{{$client->name}}</td>
                          <td>{{date("F", mktime(0, 0, 0, $client->tax_filing_month, 10))}}</td>
                          <td></td>
                          <td>{{$client->business_type_id}}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4"></td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 col-sm-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">事業者情報</h3>
              </div>
              <div class="card-body">
                <table class="table-bordered table">
                  <tbody>
                    <tr>
                      <td class="w-25 text-bold">事務所名</td>
                      <td class="w-75">{{Auth::user()->accountingOffice->name ?? ''}}</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">所在地</td>
                      <td class="w-75">{{Auth::user()->accountingOffice->address ?? ''}}</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">代表者
                      </td>
                      <td class="w-75">{{Auth::user()->accountingOffice->representative ?? ''}}</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">ご利用スタッフ
                      </td>
                      <td class="w-75">@if(Auth::user()->accountingOffice->subscription) {{
                        Auth::user()->accountingOffice->subscription->status ?? ''
                      }} @else FREE USER @endif</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">ご利用期日
                      </td>
                      <td class="w-75">{{date_format(Auth::user()->accountingOffice->created_at, 'j F Y') ?? ''}}</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">利用メンバー数
                      </td>
                      <td class="w-75">{{Auth::user()->accountingOffice->staff->count()}}名
                      </td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">登録顧客数
                      </td>
                      <td class="w-75">{{Auth::user()->accountingOffice->clients->count()}}社</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@section('extra-scripts')
@endsection
