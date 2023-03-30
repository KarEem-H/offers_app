@component('mail::message')
# Introduction

Your Credentails:<br>
Email: {{ $admin->email }}<br>
Password: {{ $admin->defaultPassword }}<br>

@component('mail::button', ['url' =>  $url ])
Go To Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
