<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_name',
        'subdomain',
        'custom_domain',
        'company_registration_id',
        'company_address',
        'company_phone',
        'company_industry',
        'owner_name',
        'logo_path',
        'subscription_plan_id',
        'subscription_started_at',
        'subscription_expires_at',
        'status',
    ];

    protected $casts = [
        'subscription_started_at' => 'datetime',
        'subscription_expires_at' => 'datetime',
    ];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function settings()
    {
        return $this->hasOne(TenantSetting::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
