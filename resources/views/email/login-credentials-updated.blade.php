@component('mail::message')

Login Credentials has been updated for user : {{$login_id}}
<br>
<br>
<hr>
Registered name: {{'\t\t'.$name}}
<br>
Email address: {{'\t\t'.$email}}
<br>
Password: {{'\t\t'.$password}}

<br>
<hr>
このメールは送信専用です。<br>
ご不明点等は、当行WEBサイトよりお問い合わせください。<br>
アップファイリング　https://upfiling.jp/
<hr>
@endcomponent
