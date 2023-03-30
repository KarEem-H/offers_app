@component('mail::message')
# Contact US

Email: {{ $contact_us->email }}<br>
Name: {{ $contact_us->name }}<br>
Phone: {{ $contact_us->phone }}<br>
Message: {{ $contact_us->message }}<br>
Time: {{ $contact_us->created_at->toDateTimeString() }}<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
