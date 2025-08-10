<?php

namespace App\Repositories\TransformDTOs;

use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract Class TransformDTOs{
    protected function transformListDTO(Collection $users): array
    {
        $function = "transformToDTO";
        return $users->map(function ($user) use ($function) {
            return $this->{$function}($user);
        })->toArray();
    }

    abstract protected function transformToDTO(Model $model): DTOSummary; 
}