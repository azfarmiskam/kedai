<?php

namespace App\View\Composers;

use App\Models\SystemSetting;
use App\Models\TenantSetting;
use Illuminate\View\View;

class ThemeComposer
{
    public function compose(View $view)
    {
        $systemSettings = SystemSetting::first();
        
        // Default values if no system settings exist
        $defaults = [
            'system_name' => 'Kedai',
            'logo_path' => null,
            'favicon_path' => null,
            'color_primary' => '#1e3a8a',
            'color_secondary' => '#3b82f6',
            'color_tertiary' => '#60a5fa',
        ];

        // Get tenant settings if in tenant context (for future multi-tenancy)
        $tenantSettings = null;
        // Note: tenant() helper will be available after Stancl Tenancy is fully configured
        // For now, we'll just use system settings
        
        $theme = [
            'system_name' => $systemSettings->system_name ?? $defaults['system_name'],
            'logo' => $tenantSettings->logo_path ?? $systemSettings->logo_path ?? $defaults['logo_path'],
            'favicon' => $tenantSettings->favicon_path ?? $systemSettings->favicon_path ?? $defaults['favicon_path'],
            'colors' => [
                'primary' => $tenantSettings->color_primary ?? $systemSettings->color_primary ?? $defaults['color_primary'],
                'secondary' => $tenantSettings->color_secondary ?? $systemSettings->color_secondary ?? $defaults['color_secondary'],
                'tertiary' => $tenantSettings->color_tertiary ?? $systemSettings->color_tertiary ?? $defaults['color_tertiary'],
            ],
        ];

        $view->with('theme', $theme);
    }
}
