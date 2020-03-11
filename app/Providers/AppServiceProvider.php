<?php

namespace App\Providers;

use App\Notifications\QueueFailed;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\Telegram\TelegramChannel;
use Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::resourceVerbs([
            'create' => 'aanmaken',
            'edit' => 'bewerken',
        ]);

        Schema::defaultStringLength(191);

        Queue::failing(function (JobFailed $event) {
            Notification::route(TelegramChannel::class, config('app.error_receiver_token'))
                ->notify(new QueueFailed($event->job, $event->exception));
        });
    }
}
