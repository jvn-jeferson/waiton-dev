@component('mail::message')
# {{$name}}　様
<br>
パスワードをリセットするため、以下の仮パスワードを発行いたしました。<br>
以下のURLからアクセスして新しいパスワードを設定してください。<br>
<br>
<a href="{{$url}}">{{$url}}</a>
<h4>ログインID： 変更ありません</h4>
<h4>仮パスワード： {{$temp_pass}}</h4><br>
（ログイン時にパスワードの設定をお願いしております<br>
<br>
<br>
<hr>
このメールは送信専用です。<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。<br>
アップファイリング　https://upfiling.jp/
<hr>
@endcomponent
