@component('mail::message')
# Welcome to UpFiling.jp

Hi {{$user->clientStaff->name}},<br>

We are glad to let you know that you and your business, {{$user->clientStaff->client->name}} has been registered as a clientelle for {{$user->clientStaff->client->host->name}}<br>
In order to gain access to our features, you need to complete your registration by updating your login password.<br>

Please click the button bellow or copy this link to your browser in order to complete your registration. <br>
<br>
<a href="{{$url}}">{{$url}}</a>
<br>

You will need the following information to complete your registration <br>

<h4>LOGIN ID: {{$user->login_id}}</h4>
<h4>TEMPORARY PASSWORD: {{$password}}</h4>

@component('mail::button', ['url' => $url, 'color' => 'success'])
Complete Registration
@endcomponent

@endcomponent