@component('mail::message')
# ACCESS GRANTED

Your request to access an archived record has been approved.<br>
Please click on the link below to proceed. Use this password to access the archived record.

<h4>ONE TIME PASSWORD: {{$password}}</h4>

@component('mail::button', ['url' => $url, 'color' => 'success'])
GO TO ARCHIVE
@endcomponent
@endcomponent