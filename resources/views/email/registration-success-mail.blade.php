@component('mail::message')
# 題名　会計事務所名様からのご招待メール


会計事務所とクライアントの情報プラットフォーム <br>
UpFiling.jpをご利用いただきありがとうございます。<br>
<br>
会計事務所名　様よりご招待メールが発行されました。<br>
<br>
以下のURLからアクセスしていただき、UpFiling.jpのログイン情報を設定してください。<br>
<br>
<a href="{{$url}}">{{$url}}</a>
<br>
<br>
<h4>
管理者ログインID：{{$user->login_id}}
</h4>
<h4>
初期パスワード： {{$password}}
</h4>
（ログイン時にパスワードの設定をお願いしております）


@component('mail::button', ['url' => $url, 'color' => 'success'])
完全な登録
@endcomponent

@endcomponent