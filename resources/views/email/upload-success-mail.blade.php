@component('mail::message')
# Your files were uploaded successfully.

{{$message}}


<br>

Regards,<br>
{{config('app.name')}} Support

@endcomponent