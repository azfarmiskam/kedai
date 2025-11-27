<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Exception;

class WhatsAppService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.whatsapp_from');

        if ($sid && $token) {
            $this->client = new Client($sid, $token);
        }
    }

    /**
     * Send a WhatsApp message via Twilio
     *
     * @param string $to
     * @param string $message
     * @return array
     */
    public function sendMessage(string $to, string $message): array
    {
        if (!$this->client) {
            return [
                'success' => false,
                'error' => 'Twilio client not configured',
            ];
        }

        try {
            // Ensure phone number has whatsapp: prefix
            if (!str_starts_with($to, 'whatsapp:')) {
                $to = 'whatsapp:' . $to;
            }

            $twilioMessage = $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );

            return [
                'success' => true,
                'message_sid' => $twilioMessage->sid,
                'status' => $twilioMessage->status,
            ];
        } catch (Exception $e) {
            Log::error('WhatsApp send message exception', [
                'message' => $e->getMessage(),
                'to' => $to,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validate Twilio credentials
     *
     * @return array
     */
    public function validateCredentials(): array
    {
        if (!$this->client) {
            return [
                'success' => false,
                'error' => 'Twilio credentials not configured',
            ];
        }

        try {
            // Try to fetch account info
            $account = $this->client->api->v2010->accounts(config('services.twilio.sid'))->fetch();

            return [
                'success' => true,
                'account_name' => $account->friendlyName,
                'status' => $account->status,
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
     * @param string $to
     * @return array
     */
    public function sendTestMessage(string $to): array
    {
        $message = "🎉 *Test Notification*\n\n";
        $message .= "This is a test message from " . config('app.name') . ".\n";
        $message .= "Your WhatsApp notifications are working correctly!\n\n";
        $message .= "Sent at: " . now()->format('Y-m-d H:i:s');

        return $this->sendMessage($to, $message);
    }

    /**
     * Format seller registration notification message
     *
     * @param array $sellerData
     * @return string
     */
    public function formatSellerNotification(array $sellerData): string
    {
        $message = "🎉 *New Seller Registered!*\n\n";
        $message .= "📊 *Company:* {$sellerData['company_name']}\n";
        $message .= "🌐 *Subdomain:* {$sellerData['subdomain']}.kedai.test\n";
        $message .= "📧 *Email:* {$sellerData['email']}\n";
        
        if (!empty($sellerData['phone'])) {
            $message .= "📱 *Phone:* {$sellerData['phone']}\n";
        }
        
        if (!empty($sellerData['plan'])) {
            $message .= "💳 *Plan:* {$sellerData['plan']}\n";
        }
        
        $message .= "\n⏰ *Registered:* " . now()->format('Y-m-d H:i:s') . "\n";
        
        if (!empty($sellerData['dashboard_url'])) {
            $message .= "\n👉 View in Admin Panel:\n{$sellerData['dashboard_url']}";
        }

        return $message;
    }
}
