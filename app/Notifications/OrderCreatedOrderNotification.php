<?php

namespace App\Notifications;

use App\Mail\MailOrderCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedOrderNotification extends Notification 
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
    public string $name,
    public string $numberOrder,
    public array $products
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailOrderCreated
    {
        return (new MailOrderCreated($this->name, $this->numberOrder, $this->products))->to($notifiable->email);
                   
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}