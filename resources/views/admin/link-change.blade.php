@extends('layouts.admin')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card p-2">
                    <div class="card-header">
                        <h3 class="card-title text-center">
                            所管会計事務所を変更したい顧客情報の照会
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row p-1">
                            <div class="alert-success col-12 p-3">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="customer_number" class="control-label text-dark">顧客番号</label>
                                        <input type="text" accept="number" class="form-control col-3" placeholder="顧客番号" name="customer_number" id="customer_number">
                                    </div>
                                    <div class="form-group">
                                        <label for="desintation_number" class="control-label text-dark">顧客番号</label>
                                        <input type="text" accept="number" class="form-control col-3" placeholder="顧客番号" name="desintation_number" id="desintation_number">
                                    </div>
                                    <div class="form-group form-row">
                                        <input type="submit" value="照会" class="btn btn-success col-4 offset-4" id="submit">
                                    </div>
                                </form>
                            </div>
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