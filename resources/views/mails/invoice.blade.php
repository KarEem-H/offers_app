@component('mail::message')
# Booking Invoice

Offer: {{ $lead->booking->offerRelation->title }}<br>
Reservetion ID: {{ $lead->id }}<br>
Offer amount: {{ $lead->booking->offerRelation->discount_price }} SAR<br>
Branch: {{ $lead->booking->branch }}<br>
Name: {{ $lead->name }}<br>
Email: {{ $lead->email }}<br>
Date: {{ $lead->booking->updated_at->toDateString() }}<br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent





