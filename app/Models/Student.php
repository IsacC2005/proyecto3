<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable =[
        'name',
        'surname'
    ];

    public function representative(): BelongsTo{
        return $this->belongsTo(Representative::class);
    }

    public function enrollment(): BelongsToMany{
        return $this->belongsToMany(Enrollment::class);
    }

    public function evaluation_items(): BelongsToMany{
        return $this->belongsToMany(EvaluationItem::class)
            ->withPivot('note')
            ->withTimestamps();
    }
}
