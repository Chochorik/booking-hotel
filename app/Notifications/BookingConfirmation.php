<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class BookingConfirmation extends Notification
{
    public $booking, $userId;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $userId)
    {
        $this->booking = $booking;
        $this->userId = $userId;
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
        $confirmationLink = url("/confirm-booking/{$this->booking->id}/{$this->userId}");

        return (new MailMessage)
            ->greeting('Здравствуйте!')
            ->subject('Подтверждение бронирования')
            ->line('Спасибо за бронирование нашего отеля.')
            ->line('Пожалуйста, подтвердите ваш выбор, перейдя по ссылке ниже:')
            ->action('Подтвердить бронирование', $confirmationLink)
            ->line('Если вы не совершали бронирование, проигнорируйте это сообщение.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
        ];
    }
}
