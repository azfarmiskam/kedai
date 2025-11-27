<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\TelegramService;
use App\Services\WhatsAppService;

class NewSellerRegistered extends Notification
{
    use Queueable;

    protected $sellerData;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $sellerData)
    {
        $this->sellerData = $sellerData;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        $channels = [];

        // Check user's notification preferences
        $preferences = $notifiable->notification_preferences ?? [];

        if (!empty($preferences['telegram_enabled']) && !empty($notifiable->telegram_chat_id)) {
            $channels[] = 'telegram';
        }

        if (!empty($preferences['whatsapp_enabled']) && !empty($notifiable->whatsapp_number)) {
            $channels[] = 'whatsapp';
        }

        return $channels;
    }

    /**
     * Send via Telegram
     */
    public function toTelegram(object $notifiable)
    {
        $telegramService = app(TelegramService::class);
        $message = $telegramService->formatSellerNotification($this->sellerData);
        
        return $telegramService->sendMessage($notifiable->telegram_chat_id, $message);
    }

    /**
     * Send via WhatsApp
     */
    public function toWhatsApp(object $notifiable)
    {
        $whatsappService = app(WhatsAppService::class);
        $message = $whatsappService->formatSellerNotification($this->sellerData);
        
        return $whatsappService->sendMessage($notifiable->whatsapp_number, $message);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return $this->sellerData;
    }
}
