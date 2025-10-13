<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Representative extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'idcard',
        'phone',
        'name',
        'surname',
        'direction'
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }


    /*

    TODO:  funcio para crear registro cuando se afecte esta tabla en la bd
    */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }
}
