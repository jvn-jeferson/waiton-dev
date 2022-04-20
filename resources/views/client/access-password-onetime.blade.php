@extends('layouts.client-secure')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="p-3">
                <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                    <h2 class="display-6">保存された情報へのアクセス</h2>
                    <p class="lead">メールに記載されているワンタイムパスワードを入力してください。有効期限は24時間です。</p>
                </div>

                <div class="mt-2 text-center">
                    <input type="password" name="" id="" class="form-control" placeholder="パスワードを入力してください">
                    <button class="btn btn-primary mt-2">確認</button>
                </div>
            </div>
        </div>
    </div>
@endsection