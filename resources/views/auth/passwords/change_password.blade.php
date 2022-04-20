@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="form-title">自分のパスワードを設定します。</h2>
                    <form action="update-password">
                        <input type="hidden" name="uid" id="uid" value="{{$uid}}">
                        <div class="form-group">
                            <label for="password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="password" id="password" placeholder="以前のパスワード"/>
                        </div> 
                        <h4 class="lead my-2">メールで送信されたパスワードを入力してください。</h4>
                        <div class="form-group">
                            <label for="new_password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="new_password" id="new_password" placeholder="新しいパスワード"/>
                        </div>
                        <div class="form-group">
                            <label for="retype_password"><i class="zmdi zmdi-lock"></i></label>
                            <input type="password" name="retype_password" id="retype_password" placeholder="パスワードを再入力してください"/>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection