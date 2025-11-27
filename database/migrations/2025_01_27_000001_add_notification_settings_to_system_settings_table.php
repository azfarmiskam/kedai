<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            // Telegram settings
            $table->boolean('telegram_enabled')->default(false)->after('value');
            $table->text('telegram_bot_token')->nullable()->after('telegram_enabled');
            $table->text('telegram_chat_id')->nullable()->after('telegram_bot_token');
            
            // WhatsApp/Twilio settings
            $table->boolean('whatsapp_enabled')->default(false)->after('telegram_chat_id');
            $table->text('twilio_account_sid')->nullable()->after('whatsapp_enabled');
            $table->text('twilio_auth_token')->nullable()->after('twilio_account_sid');
            $table->string('twilio_whatsapp_from')->nullable()->after('twilio_auth_token');
            
            // Notification events configuration
            $table->json('notification_events')->nullable()->after('twilio_whatsapp_from');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropColumn([
                'telegram_enabled',
                'telegram_bot_token',
                'telegram_chat_id',
                'whatsapp_enabled',
                'twilio_account_sid',
                'twilio_auth_token',
                'twilio_whatsapp_from',
                'notification_events',
            ]);
        });
    }
};
