@extends('layouts.host')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto col-md-12 col-sm-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">List of Registered Clients</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-striped text-center">
                                        <thead class="thead bg-primary">
                                            <th>Select</th>
                                            <th>Business Name</th>
                                            <th>Type</th>
                                            <th>Financial Account Month</th>
                                            <th>NTA Identificaiton Info</th>
                                            <th>EL-Tax Info</th>
                                        </thead>
                                        <tbody>

                                            @forelse($clients as $client)
                                                <tr>
                                                    <td><input type="checkbox" name="select" id="select" value="{{ $client->id }}"></td>
                                                    <td>{{$client->name }}</td>
                                                    <td>{{$client->business_type_id }}</td>
                                                    <td>{{date("F", mktime(0, 0, 0, $client->tax_filing_month, 10)) }}</td>
                                                    <td>{{$client->nta_num }}</td>
                                                    <td></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No results to show</td>
                                                </tr>
                                            @endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-warning float-right text-white">Download Selected Data</button>
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