@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Registration Information</h3>
                                <div class="card-tools">
                                    <button class="btn btn-warning btn-tool">Change/Update Info</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tbody>
                                            <tr>
                                                <td class="text-bold">Office Name</td>
                                                <td>{{$account->name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Representative</td>
                                                <td>{{$account->representative}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Office Location</td>
                                                <td>{{$account->address}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Telephone Number</td>
                                                <td>{{$account->telephone}}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">User Type</td>
                                                <td>Paid member</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Active Plan</td>
                                                <td>5 company plan</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Current Clients</td>
                                                <td>4</td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold">Date of Use</td>
                                                <td>2021/3/1　～　2022/2/28　First registration {{$account->verified_at}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-sm-12 col-md-12">
                        <div class="card card-danger card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    新しいユーザーを追加する
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <td rowspan="2">
                                            <label for="user-type">Type of access</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="a">
                                                <label class="form-check-label" for="exampleRadios1">
                                                User
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="b">
                                                <label class="form-check-label" for="exampleRadios2">
                                                Manager
                                                </label>
                                            </div>
                                        </td>
                                        <td>Name</td>
                                        <td><input type="text" name="" id="" class="form-control" placeholder="Full Legal Name"></td>
                                        <td rowspan="2">
                                            <button class="btn btn-primary btn-block">Register</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email Address</td>
                                        <td><input type="email" name="" id="" class="form-control" placeholder="sample@mail.com"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-danger card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title text-bold">
                                    ユーザー管理
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-bars"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th colspan="3">
                                            User Accounts
                                        </th>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse($staffs as $staff)
                                            <tr class="align-items-center">
                                                <td rowspan="3">
                                                    <p class="text-bold">@if($staff->is_admin==1) Manager @else Staff @endif</p>
                                                    <button class="btn btn-info" type="button">Manage</button>
                                                </td>
                                                <td>ID</td>
                                                <td>{{$staff->id}}</td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td>{{$staff->name}}</td>
                                            </tr><tr>
                                                <td>email</td>
                                                <td></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">No results to show.</td>
                                            </tr>
                                        @endforelse
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
    <script type="text/javascript" src="{{ asset('js/app.js')}}"></script>
@endsection