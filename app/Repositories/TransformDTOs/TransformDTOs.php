<?php

namespace App\Repositories\TransformDTOs;

use App\DTOs\Details\DTODetail;
use App\DTOs\Searches\DTOSearch;
use App\DTOs\Summary\DTOSummary;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class TransformDTOs
{

    public function transformModel(Model $model, ?String $function = "transformToDTO")
    {
        return $this->{$function}($model);
    }

    protected function transformListDTO(Collection $models, ?String $function = "transformToDTO"): array
    {
        return $models->map(function ($model) use ($function) {
            return $this->{$function}($model);
        })->toArray();
    }

    abstract protected function transformToDTO(Model $model): DTOSummary;

    abstract protected function transformToDetailDTO(Model $model): DTODetail;

    //abstract protected function transformToSearchDTO(Model $model): DTOSearch;
}
