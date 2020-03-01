<?php

namespace App\Providers;

use App\Events\ApplicationCreated;
use App\Events\EventApplicationCreated;
use App\Listeners\SendApplicationEmailNotification;
use App\Listeners\SendEventApplicationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        ApplicationCreated::class => [
            SendApplicationEmailNotification::class,
        ],
        EventApplicationCreated::class => [
            SendEventApplicationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
