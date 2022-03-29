@component('mail::message')


管理者あてに {{$user->name}} 様より <br>
以下の閲覧の依頼が投稿されております。<br>
<br>
<hr>
資料名：決算書2022 <br>
投稿日：2022/01/22 <br>
投稿者：市川 <br>
<hr>
<br>
閲覧承認される場合には、URLとパスワードを共有してください。<br>
<br>
URL:    {{$url}} <br>
<hr>
<br>
ワンタイムパスワード: {{'     '.$password}} <br>
（有効期限は24時間です）<br>
<br>
アップファイリング　サポート
<br>

@endcomponent
