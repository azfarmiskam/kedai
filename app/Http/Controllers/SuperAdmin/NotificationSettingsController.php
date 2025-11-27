<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Services\TelegramService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class NotificationSettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::first();
        
        return view('superadmin.settings.notifications', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'telegram_enabled' => 'boolean',
            'telegram_bot_token' => 'nullable|string',
            'telegram_chat_id' => 'nullable|string',
            'whatsapp_enabled' => 'boolean',
            'twilio_account_sid' => 'nullable|string',
            'twilio_auth_token' => 'nullable|string',
            'twilio_whatsapp_from' => 'nullable|string',
        ]);

        $settings = SystemSetting::first();

        // Update Telegram settings
        $settings->telegram_enabled = $request->boolean('telegram_enabled');
        if ($request->filled('telegram_bot_token')) {
            $settings->telegram_bot_token = Crypt::encryptString($request->telegram_bot_token);
        }
        if ($request->filled('telegram_chat_id')) {
            $settings->telegram_chat_id = Crypt::encryptString($request->telegram_chat_id);
        }

        // Update WhatsApp settings
        $settings->whatsapp_enabled = $request->boolean('whatsapp_enabled');
        if ($request->filled('twilio_account_sid')) {
            $settings->twilio_account_sid = Crypt::encryptString($request->twilio_account_sid);
        }
        if ($request->filled('twilio_auth_token')) {
            $settings->twilio_auth_token = Crypt::encryptString($request->twilio_auth_token);
        }
        if ($request->filled('twilio_whatsapp_from')) {
            $settings->twilio_whatsapp_from = $request->twilio_whatsapp_from;
        }

        $settings->save();

        return redirect()->route('superadmin.settings.notifications')
            ->with('success', 'Notification settings updated successfully!');
    }

    public function testTelegram(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string',
        ]);

        $telegramService = app(TelegramService::class);
        $result = $telegramService->sendTestMessage($request->chat_id);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Test message sent successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error'] ?? 'Failed to send test message',
        ], 400);
    }

    public function testWhatsApp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        $whatsappService = app(WhatsAppService::class);
        $result = $whatsappService->sendTestMessage($request->phone_number);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Test message sent successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error'] ?? 'Failed to send test message',
        ], 400);
    }
}
