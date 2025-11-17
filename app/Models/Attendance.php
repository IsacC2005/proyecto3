<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Attendance extends Pivot
{
    protected $table = 'attendances';

    protected $fillable = [
        'learning_project_id',
        'student_id',
        'day',
        'attendance'
    ];

    public function LearningProject(): BelongsTo
    {
        return $this->belongsTo(LearningProject::class, 'learning_project_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
