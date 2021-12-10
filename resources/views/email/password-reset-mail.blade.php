@component('mail::message')
# Password Reset Granted

Hi {{$name}}, <br>

Your request for a password reset has been granted. Please click on the button below to change your password.

@component('mail::button', ['url' => $url, 'color' => 'success'])
Update Password
@endcomponent


Regards, <br>
{{config('app.name')}} Support Team
@endcomponent