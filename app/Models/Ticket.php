<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'student_id',
        'learning_project_id',
        'average',
        'personality',
        'content',
        'suggestions'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function learning_project(): BelongsTo
    {
        return $this->belongsTo(LearningProject::class);
    }
}
