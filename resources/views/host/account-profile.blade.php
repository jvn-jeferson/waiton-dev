@extends('layouts.host')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto col-md-12 col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Profile Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="card">
                                        <div class="card-header" style="background-color: #74828F;">
                                            Card Details
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <h2>{{Auth::user()->accountingOfficeStaff->accountingOffice->name ?? ''}}</h2>
                                                </div>
                                                <div class="col-md-3">
                                                    <i class="@if($customer['brand'] == 'visa') fab fa-cc-visa @else fab fa-cc-mastercard @endif" style="font-size:70px;"></i>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Credit Card:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    ****-*****{{$customer['last_digits']}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Exp Year/Month:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    {{$customer['exp_month'].'/'.$customer['exp_year'] ?? ''}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Card Type:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <p style="text-transform: capitalize;">{{$customer['brand'] ?? ''}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Status:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <div>
                                                        <span class="badge badge-primary" style="text-transform: capitalize;font-size:13px;">{{$customer['status'] ?? ''}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($customer['status'] == 'trialing')
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Trial End At:</p>
                                                </div>
                                                <div class="col-md-8">
                                                    <div>
                                                        <p>{{$customer['trial_at'] ?? ''}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <br>
                                            <button class="btn-sm btn-success">Change Subscription</button>
                                            <button class="btn-sm btn-danger">Cancel Subscription</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card">
                                        <div class="card-header" style="background-color: #74828F;">
                                           Billing Invoice
                                        </div>
                                        <div class="card-body">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Payment Status</th>
                                                    <th>PDF</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoice_details as $invoice)
                                                <tr>
                                                    <td>{{$invoice->id ?? ''}}</td>
                                                    <td>{{$invoice->date ?? ''}}</td>
                                                    <td>{{$invoice->payment_invoice_status ?? ''}}</td>
                                                    <td>{{$invoice->status ?? ''}}</td>
                                                    <td><a href="{{$invoice->invoice_pdf}}" class="btn-sm btn-danger">Download</a></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
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
@endsection
