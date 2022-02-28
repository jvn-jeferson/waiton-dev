@component('mail::message')

<h4>
    会計事務所とクライアントの情報プラットフォーム
</h4>

<p>
    UpFiling.jpをご利用いただきありがとうございます。
</p>

<br>

<p>
{{$name}} 様によりユーザー登録されました。
</p>

<br>
以下のURLからアクセスしていただき、UpFiling.jpのユーザーログイン情報を設定してください。
<br>

<a href="{{$url}}">{{$url}}</a>
@component('mail::button', ['url' => $url, 'color' => 'success'])
完全な登録
@endcomponent

<h4>
    ログインID： <strong>{{$user->login_id}}</strong>
</h4>
<h4>
    初期パスワード： <strong>{{$password}}</strong>
</h4>
<br>
<h6>
    （ログイン時にパスワードの設定をお願いしております）
</h6>

<hr>
このメールは送信専用です。
<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。
<br>
アップファイリング　https://upfiling.jp/
<hr>
@endcomponent
