<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LearningProjectQualiteStudent extends Pivot
{

    protected $table = 'learning_project_qualitie_student';

    protected $fillable = [
        'learning_project_id',
        'qualitie_id',
        'student_id',
        'qualitie'
    ];

    public function LearningProject(): BelongsTo
    {
        return $this->belongsTo(LearningProject::class, 'learning_project_id');
    }

    public function qualitie(): BelongsTo
    {
        return $this->belongsTo(Qualitie::class, 'qualitie_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
