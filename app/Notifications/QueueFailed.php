<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class QueueFailed extends Notification
{
    use Queueable;

    private $job;
    private $exception;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($job, $exception)
    {
        $this->job = $job;
        $this->exception = $exception;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(config('app.error_receiver_token'))
            ->content(
                '
                A Queue job failed
                *Job:*
                ' . $this->job . '
                *Exception:*
                ' . $this->exception . '
                '
            );
    }
}
