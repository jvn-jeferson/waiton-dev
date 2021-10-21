@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-sm-12 col-md-12">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Current Active Subscription
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr class="text-bold">
                                                <td class="w-25">Plan of Choice</td>
                                                <td>Basic</td>
                                            </tr>
                                            <tr class="text-bold">
                                                <td class="w-25">Plan Inclusions</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="w-25">Maximum Users</td>
                                                <td>Upto 5 Unique Clients</td>
                                            </tr>
                                            <tr>
                                                <td class="w-25">Media Storage Allotment</td>
                                                <td>Upto 50GB/Month</td>
                                            </tr>
                                            <tr>
                                                <td class="w-25">Number of Account Users</td>
                                                <td>Upto 2 Managers and 3 Users</td>
                                            </tr>
                                            <tr class="text-bold">
                                                <td class="w-25">Subscription Status</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Current Number of Clients</td>
                                                <td>4</td>
                                            </tr>
                                            <tr>
                                                <td>Media Storage Used</td>
                                                <td>10 GB</td>
                                            </tr>
                                            <tr>
                                                <td>Number of Account Users</td>
                                                <td>1 Administrator : 1 User</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')
    <script type="text/javascript" src="{{ asset('js/app.js')}"></script>
@endsection