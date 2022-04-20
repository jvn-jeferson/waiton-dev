@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-md-8 text-center">
                <h4 class="text-bold">
                    保管情報へのアクセス
                </h4>
                <p class="lead text-left mt-5">
                    メールに記載されたワンタイムパスワードを入力してください。<br>
                    有効期限は24時間です。
                </p>
                <form action="{{route('one-time-access', ['record_id' => $access_id])}}" method="post">
                    @csrf
                    <input type="password" name="password" id="password" class="form-control text-center @error('password') is-invalid @enderror">
                    @error('password')
                        <span class="text-danger">
                            {{$message}}
                        </span>
                    @enderror
                    <button class="btn btn-warning col-2 offset-5 btn-block mt-2" type="submit">閲覧する</button>
                </form>
            </div>
        </div>
    </div>
@endsection