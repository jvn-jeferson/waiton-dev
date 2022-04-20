@component('mail::message')
# Inquiry

A user has asked this question.
@component('mail::panel')
{{$inquiry}}
@endcomponent

<br>
Reply to: {{$sender}}
@endcomponent