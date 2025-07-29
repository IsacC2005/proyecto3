<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schoole_year',
        'section',
        'classroom'
    ];

    public function teacher(): BelongsTo{
        return $this->belongsTo(Teacher::class);
    }

    public function learning_project(): HasMany{
        return $this->hasMany(LearningProject::class);
    }

    public function students(): BelongsToMany{
        return $this->belongsToMany(Student::class);
    }
}
