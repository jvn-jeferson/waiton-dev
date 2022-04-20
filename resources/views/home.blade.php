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
                  Basic Plus
                  {{-- {{$subscription->name}} --}}
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
                  10 / 10
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
                <table class="table-hover table table-striped table-bordered text-center">
                  <thead class="thead bg-info">
                    <th>Business Name</th>
                    <th>Final Accounts Month</th>
                    <th>Proposal Month</th>
                    <th>Classification</th>
                  </thead>
                  <tbody>
                    {{-- @foreach($companies as $company) --}}
                    <tr>
                      <td>ABC Co., Ltd.</td>
                      <td>March</td>
                      <td>May</td>
                      <td>Sure</td>
                    </tr>
                    {{-- @endforeach --}}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-12 col-sm-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">ビジネス情報</h3>
              </div>
              <div class="card-body">
                <table class="table-bordered table">
                  <tbody>
                    <tr>
                      <td class="w-25 text-bold">Office Name</td>
                      <td class="w-75">Ichikawa Tax Accountant Office</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">Business Address</td>
                      <td class="w-75">2-6-7 Higashitenma, Kita-ku, Osaka-shi, Osaka</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">Representative</td>
                      <td class="w-75">Kinichi Ichikawa</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">User Staff</td>
                      <td class="w-75">Paid Members</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">Subscription Info</td>
                      <td class="w-75">2021/3/1　～　2022/2/28</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">Users</td>
                      <td class="w-75">2</td>
                    </tr>
                    <tr>
                      <td class="w-25 text-bold">Registered Clients</td>
                      <td class="w-75">10</td>
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
  <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
@endsection
