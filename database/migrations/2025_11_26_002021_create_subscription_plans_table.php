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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('RM');
            $table->enum('billing_period', ['monthly', 'yearly', 'lifetime'])->default('monthly');
            $table->enum('plan_type', ['website', 'ecommerce'])->default('website');
            $table->integer('product_limit')->default(0);
            $table->boolean('custom_domain')->default(false);
            $table->boolean('remove_trademark')->default(false);
            $table->integer('email_accounts')->default(0);
            $table->boolean('priority_support')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
