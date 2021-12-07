@extends('layouts.host-individual')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Past Financial Results
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover table-striped text-center">
                            <thead class="thead-dark">
                                <th>Type</th>
                                <th>Settlement Date</th>
                                <th>Completed Tax Return</th>
                                <th>Proposal Date</th>
                                <th>Recognition Date</th>
                                <th>Explanation Video</th>
                            </thead>
                            <tbody>
                                <tr class="align-center">
                                    <td>1</td>
                                    <td><p class="text-dark">March 31, 2021</p> <a href="{{route('access-archive', ['file_id' => $hashids->encode(12), 'client_id' => $hashids->encode($client->id)])}}" class="btn btn-primary">Access</a></td>
                                    <td>Financial statements / tax returns (corporate tax / local tax / consumption tax) FY03 / 2021</td>
                                    <td>May 28, 2021</td>
                                    <td>May 30, 2021</td>
                                    <td>no data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('extra-scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection