@extends('layouts.host-individual')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>October 10, 2021</td>
                                        <td>Payment of corporate tax, local tax and consumption tax</td>
                                    </tr>
                                    <tr>
                                        <td>September 10, 2021</td>
                                        <td>Income tax withholding</td>
                                    </tr>
                                    <tr>
                                        <td>August 30, 2021</td>
                                        <td>Interim payment of corporate tax, local tax and consumption tax</td>
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