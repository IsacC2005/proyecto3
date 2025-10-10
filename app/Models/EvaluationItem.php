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
        // Apunta a una clase Dummy o a sí mismo, pero especifica la tabla pivot
        return $this->belongsToMany(self::class, 'evaluation_item_student', 'evaluation_item_id', 'student_id')
            ->withPivot('note', 'student_id', 'evaluation_item_id');
    }
}
