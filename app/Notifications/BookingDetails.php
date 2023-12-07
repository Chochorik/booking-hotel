<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingDetails extends Notification
{
    public $booking, $user, $room;
    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $user, $room)
    {
        $this->booking = $booking;
        $this->user = $user;
        $this->room = $room;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Здравствуйте!')
            ->subject("Бронирование номера подтверждено")
            ->line("{$this->user->name}, спасибо за бронирование номера нашего отеля!")
            ->line("Ваш номер: {$this->room->title}")
            ->line("Период бронирования: с {$this->booking->started_at} по {$this->booking->finished_at} (дней: {$this->booking->days})")
            ->line("Стоимость: {$this->booking->price}₽");
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
