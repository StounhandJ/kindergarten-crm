<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification// implements ShouldQueue
{
    use Queueable;

    private string $price;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $price)
    {
        $this->price = $price;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ["nexmo"];
    }

    /**
     * Получить SMS-представление уведомления.
     *
     * @param mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
            ->content(`Необходимо оплатить {$this->price}`)
            ->unicode();
    }
}
