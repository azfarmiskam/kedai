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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default('Kedai');
            $table->text('site_description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('color_primary')->default('#1e3a8a'); // Navy Blue
            $table->string('color_secondary')->default('#3b82f6'); // Light Blue
            $table->string('color_tertiary')->default('#60a5fa'); // Lighter Blue
            $table->string('default_language')->default('en');
            $table->string('default_currency')->default('RM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
