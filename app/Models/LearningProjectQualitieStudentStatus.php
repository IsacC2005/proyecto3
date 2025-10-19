<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningProjectQualitieStudentStatus extends Model
{
    protected $table = 'learning_project_qualitie_student_status';

    protected $fillable = [
        'learning_project_id',
        'student_id',
        'status'
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
