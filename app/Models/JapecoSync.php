<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JapecoSync extends Model
{
    protected $table = 'japeco_sync';

    protected $fillable = [
        'time_sync'
    ];
}
