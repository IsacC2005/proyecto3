<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingIA extends Model
{
    protected $table = 'setting_ia';

    protected $fillable = [
        'system_instruction',
        'model',
        'key',
        'temperature'
    ];
}
