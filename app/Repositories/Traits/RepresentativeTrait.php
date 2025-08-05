<?php

namespace App\Repositories\Traits;

use App\DTOs\RepresentativeDTO;
use App\Models\Representative;

trait RepresentativeTrait
{
    private function transformListDTO(array $representatives): array
    {
        return array_map([$this, 'transformToDTO'], $representatives);
    }

    private function transformToDTO(Representative $representative): RepresentativeDTO
    {
        return new RepresentativeDTO(
            id: $representative->id,
            idcard: $representative->idcard,
            phone: $representative->phone,
            name: $representative->name,
            surname: $representative->surname,
            direction: $representative->direction
        );
    }
}
?>