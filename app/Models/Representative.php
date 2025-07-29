<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Representative extends Model
{
    protected $fillable= [
        'idcard',
        'phone',
        'name',
        'surname',
        'direction'
    ];

    public function students(): HasMany{
        return $this->hasMany(Student::class);
    }
}
