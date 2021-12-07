@extends('layouts.client')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="text-bold card-title">
                            FAQ
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td class="text-bold">Q</td>
                                    <td class="text-primary">どうしてこうですか？</td>
                                </tr>
                                <tr>
                                    <td class="text-bold">A</td>
                                    <td class="text-primary">それはこういうことです。</td>
                                </tr>
                                <tr></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('extra-scripts')

@endsection
