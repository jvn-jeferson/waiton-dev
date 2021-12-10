@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-md-8 text-center">
                <h4 class="text-bold">
                    パスワードは正常に更新されました。
                </h4>
                <p class="lead">
                    <a href="{{route('login')}}" class="btn btn-primary">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection