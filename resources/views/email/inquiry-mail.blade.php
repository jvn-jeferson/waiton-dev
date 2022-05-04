@component('mail::message')
# {{$staff->name}}　様より問い合わせありました。
<br>
<hr>
<span class="text-bold">所属：</span>{{$affiliation->name}}
<br>
<span class="text-bold">所属：</span>{{$user->email}}
<br>
<br>
<hr>
問合わせ内容
<br>
{!!nl2br($content)!!}
<hr>
<br>
このメールは送信専用です。
直接メールアドレスに返答してください。
@endcomponent