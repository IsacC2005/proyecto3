<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DailyClass extends Model
{
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
}
