<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\{
    AdminCreated,
    NewsletterSubscription,
    ContactUsEvent,
    PaymentSuccessCallback,
    LeadCreated,
    LeadUpdated,
    OfferCreated,
    OfferDeleted,
    OfferUpdated
};

use App\Listeners\{
    DeleteCenterlizedOffer,
    SendNewsletterMail,
    SendContactUsMail,
    SendMailWithCredentials,
    SendSuccessPaymentMail,
    StoreCenterlizedContactUs,
    StoreCenterlizedLead,
    StoreCenterlizedOffer,
    UpdateCenterlizedLead,
    UpdateCenterlizedOffer
};

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewsletterSubscription::class => [
            SendNewsletterMail::class,
        ],
        ContactUsEvent::class => [
            SendContactUsMail::class,
            StoreCenterlizedContactUs::class,
        ],
        PaymentSuccessCallback::class => [
            SendSuccessPaymentMail::class
        ],
        AdminCreated::class => [
            SendMailWithCredentials::class
        ],
        LeadCreated::class => [
            StoreCenterlizedLead::class
        ],
        LeadUpdated::class => [
            UpdateCenterlizedLead::class
        ],
        OfferCreated::class => [
            StoreCenterlizedOffer::class
        ],
        OfferUpdated::class => [
            UpdateCenterlizedOffer::class
        ],
        OfferDeleted::class => [
            DeleteCenterlizedOffer::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
