<?php

namespace App\Notifications;

use App\Models\Child;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class SmsNotification extends Notification //implements ShouldQueue
{

    private string $price;
    private Carbon $month;
    private Child $child;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $price, Carbon $month, Child $child)
    {
        $this->price = $price;
        $this->month = $month;
        $this->child = $child;
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
            ->content(
                sprintf(
                    "Добрый день, оплата за садик, %s, у вас %s",
                    $this->month->monthName,
                    $this->price
                )
            )
            ->unicode();
    }

    public function middleware()
    {
        return [
            (new WithoutOverlapping(
                sprintf(
                    "%_%_%",
                    $this->child->getId(),
                    $this->month,
                    $this->price,
                )
            ))->dontRelease()
        ];
    }
}
