<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class DailyClass extends Model
{

    use LogsActivity;

    protected $fillable = [
        'date',
        'title',
        'content',
        'learning_project_id'
    ];

    public function learning_project(): BelongsTo
    {
        return $this->belongsTo(LearningProject::class);
    }

    public function evaluation_items(): HasMany
    {
        return $this->hasMany(EvaluationItem::class);
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
