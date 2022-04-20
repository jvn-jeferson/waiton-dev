@component('mail::message')

<h4>
    {{$name}}
</h4>

{{$accountingOffice->name}} 様からのご招待メール <br>
{{$accountingOffice->name}} とクライアントの情報プラットフォーム <br>
UpFiling.jpをご利用いただきありがとうございます。<br>
<br>
{{$accountingOffice->name}}　様よりご招待メールが発行されました。<br>

<br>
以下のURLからアクセスしていただき、UpFiling.jpのユーザーログイン情報を設定してください。
<br>

<a href="{{$url}}">{{$url}}</a>

<h4>
    ログインID： <strong>{{'     '.$user->login_id}}</strong>
</h4>
<h4>
    初期パスワード： <strong>{{'     '.$password}}</strong>
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
