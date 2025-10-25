<?php

namespace App\Factories;

use App\DTOs\Details\DTODetail;
use Illuminate\Http\Request;
use App\DTOs\Summary\DTOSummary;

interface Factory
{
    public static function fromRequest(Request $request): DTOSummary;

    public static function fromRequestDetail(Request $request): DTODetail;

    public static function fromArray(array $data): DTOSummary;

    public static function fromArrayDetail(array $data): DTODetail;
}
