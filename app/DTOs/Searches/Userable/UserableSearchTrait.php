<?php

namespace App\DTOs\Searches\Userable;

use App\DTOs\Searches\UserSearchDTO;

trait UserableSearchTrait
{
    public ?int $user_id = null;
    private ?UserSearchDTO $user = null;
}

?>