@component('mail::message')

Login Credentials has been updated for user : {{$login_id}}
<br>
<br>
<hr>
Registered name: {{'     '.$name}}
<br>
Email address: {{'     '.$email}}
<br>

<br>
<hr>
このメールは送信専用です。<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。<br>
アップファイリング　https://upfiling.jp/
<hr>
@endcomponent
