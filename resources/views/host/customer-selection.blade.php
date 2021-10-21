@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-12 col-sm-12">

                        @if ( Session::has('success') )
                        <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>{{ Session::get('success') }}</strong>
                        </div>
                        @endif
                        <div class="div card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    List of Registered Clients
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="text-bold text-light">
                                            Client List
                                        </h4>
                                    </div>
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-success float-right" type="button" data-toggle="modal" data-placement="top" title="Add a new customer" data-target="#newClientModal" type="button">
                                            <i class="fas fa-plus"></i>
                                            New Client
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-12 col-md-12  table-responsive">
                                        <table class="table mt-2 table-hover table-striped text-center">
                                            <thead class="thead bg-info">
                                                <th>Business Name</th>
                                                <th>Type</th>
                                                <th>Final Accounts Month</th>
                                                <th>New Post</th>
                                                <th>Pending Verification</th>
                                            </thead>
                                            <tbody>
                                                @forelse($clients as $client)
                                                    <tr>
                                                        <td><a href="view-individual-clients/client_id={{$hashids->encode($client->id)}}/dashboard">{{$client->name}}</a></td>
                                                        <td>{{$client->business_type}}</td>
                                                        <td>{{$client->tax_filing_month}}</td>
                                                        <td></td>
                                                        <td>@if($client->verified_at == '') <a href="#" class="btn btn-danger btn-block"><i class="fas fa-circle"></i></a>@endif</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">No data to Show</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="newClientModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register a new Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="register-new-client" method="post" id="newClientForm">
                        @csrf
                        <div id="user-info-tab">
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-control" placeholder="ex. ABC Co., Ltd.">
                            </div>
                            <div class="form-group">
                                <label for="company_address">Business Address</label>
                                <input type="text" name="company_address" id="company_address" class="form-control" placeholder="">
                            </div>
                            <div class="form-row">
                                
                                <div class="form-group col-6">
                                    <label for="company_rep">Representative</label>
                                    <input type="text" name="company_rep" id="company_rep" class="form-control" placeholder="">
    
                                </div><div class="form-group col-6">
                                    <label for="company_email">Email Address</label>
                                    <input type="text" name="company_email" id="company_email" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_rep_address">Representative Address</label>
                                <input type="text" name="company_rep_address" id="company_rep_address" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="company_telephone">Telephone Number</label>
                                <input type="text" name="company_telephone" id="company_telephone" class="form-control col-6" placeholder="">
                            </div>
    
                            <div class="float-right form-group">
                                <button class="btn btn-info" type="button" id="next-page-btn">Next</button>
                            </div>
                        </div>

                        <div id="filing-info-tab" style="display:none">
                            <div class="form-group">
                                <label for="filing_month">Tax Filing Month</label>
                                <select name="filing_month" id="filing_month" class="form-control col-4">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="business_type">Business Type</label>
                                <div class="row">
                                    <div class="col-3">
                                        <input type="radio" name="business_type" id="business_type" value="1"> Sole-Propriety
                                    </div>
                                    <div class="col-3">
                                        <input type="radio" name="business_type" id="business_type" value="2"> Corporation
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company_nta_num">NTA Registration Number</label>
                                <input type="text" name="company_nta_num" id="company_nta_num" class="form-control" placeholder="">
                            </div>
                            <label for="notify_for">Notification Checklist:</label>
                            <table class="table table-striped table-hover table-responsive justify-content-center">
                                <tbody>
                                    <tr>
                                        <td>Establishment Notification Form</td>
                                        <td><input type="checkbox" name="notifier" id="notifier" value="1"></td>
                                    </tr>
                                    <tr>
                                        <td>Application for Blue Declaration</td>
                                        <td><input type="checkbox" name="notifier" id="notifier" value="2"></td>
                                    </tr>
                                    <tr>
                                        <td>Special delivery date for tax withholding tax</td>
                                        <td><input type="checkbox" name="notifier" id="notifier" value="3"></td>
                                    </tr>
                                    <tr>
                                        <td>Notification to salary payment offices, etc.</td>
                                        <td><input type="checkbox" name="notifier" id="notifier" value="4"></td>
                                    </tr>
                                    <tr>
                                        <td>Application for extension of submission deadline</td>
                                        <td><input type="checkbox" name="notifier" id="notifier"  value="5"></td>
                                    </tr>
                                    <tr>
                                        <td>Consumption tax taxable business operator</td>
                                        <td><input type="checkbox" name="notifier" id="notifier" value="6"></td>
                                    </tr>
                                    <tr>
                                        <td>Notification to consumption tax exemption business</td>
                                        <td><input type="checkbox" name="notifier" id="notifier"  value="7"></td>
                                    </tr>
                                    <tr>
                                        <td>Consumption tax taxable business operator selection notice</td>
                                        <td><input type="checkbox" name="notifier" id="notifier"  value="8"></td>
                                    </tr>
                                </tbody>
                            </table>
    
                            <div class="float-left form-group">
                                <button class="btn btn-info" type="button" id="prev-page-btn">Back</button>
                            </div>
                            <div class="float-right form-group">
                                <button class="btn btn-success" type="submit" id="submit-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-scripts')
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script>

    <script>
        const profile_div = document.querySelector('#user-info-tab')
        const filing_div = document.querySelector('#filing-info-tab')
        const next = document.querySelector('#next-page-btn')
        const prev = document.querySelector('#prev-page-btn')

        function displayNext() {
            profile_div.style.display = 'none'
            filing_div.style.display = 'block'
        }

        function displayPrevious() {
            profile_div.style.display = 'block'
            filing_div.style.display = 'none'
        }

        next.addEventListener('click', displayNext)
        prev.addEventListener('click', displayPrevious)
    </script>
@endsection