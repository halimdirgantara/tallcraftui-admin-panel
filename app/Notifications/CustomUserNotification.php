<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramMessage;
// For WhatsApp, you may need to use a custom channel or a package

class CustomUserNotification extends Notification
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        $channels = [];
        $settings = $notifiable->notificationSettings;
        if ($settings && $settings->via_app) $channels[] = 'database';
        if ($settings && $settings->via_email) $channels[] = 'mail';
        if ($settings && $settings->via_telegram) $channels[] = 'telegram';
        if ($settings && $settings->via_whatsapp) $channels[] = 'whatsapp'; // custom channel
        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notification')
            ->line($this->message);
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id ?? '')
            ->content($this->message);
    }

    // Implement WhatsApp channel if you have a package or custom channel
    // public function toWhatsapp($notifiable) { ... }
} 