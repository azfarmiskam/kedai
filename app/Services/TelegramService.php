<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TelegramService
{
    protected $botToken;
    protected $baseUrl = 'https://api.telegram.org/bot';

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
    }

    /**
     * Send a message to a Telegram chat
     *
     * @param string $chatId
     * @param string $message
     * @param array $options
     * @return array
     */
    public function sendMessage(string $chatId, string $message, array $options = []): array
    {
        try {
            $response = Http::post("{$this->baseUrl}{$this->botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => $options['parse_mode'] ?? 'HTML',
                'disable_web_page_preview' => $options['disable_preview'] ?? true,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            Log::error('Telegram send message failed', [
                'response' => $response->json(),
                'chat_id' => $chatId,
            ]);

            return [
                'success' => false,
                'error' => $response->json()['description'] ?? 'Unknown error',
            ];
        } catch (Exception $e) {
            Log::error('Telegram send message exception', [
                'message' => $e->getMessage(),
                'chat_id' => $chatId,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validate bot token by getting bot info
     *
     * @param string|null $token
     * @return array
     */
    public function validateToken(?string $token = null): array
    {
        $token = $token ?? $this->botToken;

        if (empty($token)) {
            return [
                'success' => false,
                'error' => 'Bot token is required',
            ];
        }

        try {
            $response = Http::get("https://api.telegram.org/bot{$token}/getMe");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'bot_info' => $response->json()['result'],
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['description'] ?? 'Invalid token',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send a test message
     *
     * @param string $chatId
     * @return array
     */
    public function sendTestMessage(string $chatId): array
    {
        $message = "🎉 <b>Test Notification</b>\n\n";
        $message .= "This is a test message from " . config('app.name') . ".\n";
        $message .= "Your Telegram notifications are working correctly!\n\n";
        $message .= "Sent at: " . now()->format('Y-m-d H:i:s');

        return $this->sendMessage($chatId, $message);
    }

    /**
     * Format seller registration notification message
     *
     * @param array $sellerData
     * @return string
     */
    public function formatSellerNotification(array $sellerData): string
    {
        $message = "🎉 <b>New Seller Registered!</b>\n\n";
        $message .= "📊 <b>Company:</b> {$sellerData['company_name']}\n";
        $message .= "🌐 <b>Subdomain:</b> {$sellerData['subdomain']}.kedai.test\n";
        $message .= "📧 <b>Email:</b> {$sellerData['email']}\n";
        
        if (!empty($sellerData['phone'])) {
            $message .= "📱 <b>Phone:</b> {$sellerData['phone']}\n";
        }
        
        if (!empty($sellerData['plan'])) {
            $message .= "💳 <b>Plan:</b> {$sellerData['plan']}\n";
        }
        
        $message .= "\n⏰ <b>Registered:</b> " . now()->format('Y-m-d H:i:s') . "\n";
        
        if (!empty($sellerData['dashboard_url'])) {
            $message .= "\n👉 <a href=\"{$sellerData['dashboard_url']}\">View in Admin Panel</a>";
        }

        return $message;
    }
}
