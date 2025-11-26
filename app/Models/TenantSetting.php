<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $fillable = [
        'tenant_id',
        'color_primary',
        'color_secondary',
        'color_tertiary',
        'logo_path',
        'favicon_path',
        'payment_gateways',
        'email_settings',
        'notification_settings',
    ];

    protected $casts = [
        'payment_gateways' => 'array',
        'email_settings' => 'array',
        'notification_settings' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
