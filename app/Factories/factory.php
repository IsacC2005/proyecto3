<?php

namespace App\Factories;

use Illuminate\Http\Request;
use App\DTOs\Summary\DTOSummary;

interface Factory{
    public static function fromRequest(Request $request): DTOSummary;
}