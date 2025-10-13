<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SettingIA extends Model
{

    use LogsActivity;

    protected $table = 'setting_ia';

    protected $fillable = [
        'system_instruction',
        'model',
        'key',
        'temperature'
    ];


    /*

    TODO:  funcio para crear registro cuando se afecte esta tabla en la bd
    */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }
}
