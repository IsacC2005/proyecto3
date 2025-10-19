<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Qualitie extends Model
{

    use LogsActivity;

    protected $fillable = [
        'qualitie_type_id',
        'name'
    ];

    public function qualitie_type()
    {
        return $this->hasOne(QualitieType::class);
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
