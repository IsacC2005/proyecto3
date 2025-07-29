<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'phone',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function enrollments(): HasMany{
        return $this->hasMany(Enrollment::class);
    }

    public function learning_projects(): HasMany
    {
        return $this->hasMany(LearningProject::class);
    }
}
