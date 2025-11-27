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
        Schema::table('users', function (Blueprint $table) {
            // Personal notification settings
            $table->string('telegram_chat_id')->nullable()->after('remember_token');
            $table->string('whatsapp_number')->nullable()->after('telegram_chat_id');
            $table->json('notification_preferences')->nullable()->after('whatsapp_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telegram_chat_id',
                'whatsapp_number',
                'notification_preferences',
            ]);
        });
    }
};
