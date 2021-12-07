@extends('layouts.client-secure')

@section('content')
    <div class="container">
        <div class="row justify-content-center p-3">
            <div class="col-md-8 col-lg-8 col-sm-12 p-2 align-items-center">
                <img src="{{asset('img/placeholder-image.png')}}" class="rounded img-fluid" style="height:100%">
            </div>
            <div class="col-md-4 col-lg-4 col-sm-12 p-2">
                <table class="table table-bordered table-responsive">
                    <tbody>
                        <tr>
                            <td>type</td>
                            <td>final tax return</td>
                        </tr>
                        <tr>
                            <td>Settlement Date</td>
                            <td>March 31, 2021</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Completed Tax Return</td>
                            <td class="text-info">Financial statements / tax returns (corporate tax / local tax / consumption tax) FY03 / 2021</td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-block btn-primary">Download</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Submission Date</td>
                            <td>2021年5月28日</td>
                        </tr>
                        <tr>
                            <td>Approval Date</td>
                            <td>2021年5月30日</td>
                        </tr>
                        <tr>
                            <td>Company Representative</td>
                            <td>Ichiro Yamada</td>
                        </tr>
                        <tr>
                            <td>Accounting Office Staff</td>
                            <td>Manabu Tanaka</td>
                        </tr>
                        <tr>
                            <td>Video Contributor</td>
                            <td>Kinichi Ichikawa</td>
                        </tr>
                        <tr>
                            <td>Viewing Deadline</td>
                            <td>April 1, 2028</td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td>It was a year with a lot of sales and a lot of taxes</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection