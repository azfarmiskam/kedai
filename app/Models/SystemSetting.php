<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'system_name',
        'site_description',
        'logo_path',
        'favicon_path',
        'color_primary',
        'color_secondary',
        'color_tertiary',
        'default_language',
        'default_currency',
    ];
}
