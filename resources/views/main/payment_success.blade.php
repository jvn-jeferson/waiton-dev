@extends('layouts.app')

@section('content')

<div class="col-md-12 p-2 bg-success mt-3">
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">登録に成功</h1>
        <p class="text-white">ログイン資格情報については、電子メールを確認してください。</p>
        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-500 ">Back to Login</a>
    </div>
</div>
@endsection
