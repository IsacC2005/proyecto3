<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EvaluationItem extends Model
{
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
}
