<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'school_id',
        'japeco_id',
        'grade',
        'name',
        'surname'
    ];

    // public function representative(): BelongsTo
    // {
    //     return $this->belongsTo(Representative::class);
    // }

    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(Enrollment::class);
    }

    public function evaluation_items(): BelongsToMany
    {
        return $this->belongsToMany(EvaluationItem::class)
            ->withPivot('note')
            ->withTimestamps();
    }

    /*

    TODO:  funcio para crear registro cuando se afecte esta tabla en la bd
    */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }
}
