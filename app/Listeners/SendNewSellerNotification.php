<?php

namespace App\Listeners;

use App\Events\TenantCreated;
use App\Notifications\NewSellerRegistered;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SendNewSellerNotification
{
    /**
     * Handle the event.
     */
    public function handle(TenantCreated $event): void
    {
        $tenant = $event->tenant;

        // Prepare seller data for notification
        $sellerData = [
            'company_name' => $tenant->company_name,
            'subdomain' => $tenant->subdomain,
            'email' => $tenant->email,
            'phone' => $tenant->phone ?? '',
            'plan' => $tenant->subscriptionPlan->name ?? 'Free',
            'dashboard_url' => route('superadmin.dashboard'),
        ];

        // Get all users with superadmin or admin role who have notifications enabled
        $admins = User::role(['superadmin', 'admin'])
            ->whereNotNull('notification_preferences')
            ->get()
            ->filter(function ($admin) {
                $preferences = $admin->notification_preferences ?? [];
                return !empty($preferences['new_seller_enabled']);
            });

        // Send notifications to each admin
        foreach ($admins as $admin) {
            try {
                $admin->notify(new NewSellerRegistered($sellerData));
            } catch (\Exception $e) {
                Log::error('Failed to send new seller notification', [
                    'admin_id' => $admin->id,
                    'tenant_id' => $tenant->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
