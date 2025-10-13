<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EvaluationItem extends Model
{

    use LogsActivity;


    protected $fillable = [
        'title',
        'daily_class_id',
        'note'
    ];

    public function daily_class(): BelongsTo
    {
        return $this->belongsTo(DailyClass::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)
            ->withPivot('note')
            ->withTimestamps();
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
