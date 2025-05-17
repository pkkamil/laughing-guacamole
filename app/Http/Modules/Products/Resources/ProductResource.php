<?php

namespace App\Http\Modules\Products\Resources;

use App\Http\Resources\Resource;
use App\Models\User;

class ProductResource extends Resource
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->user->{User::ID},
            'createdAt' => $this->user->{User::CREATED_AT},
            'updatedAt' => $this->user->{User::UPDATED_AT},
            'email' => $this->user->{User::EMAIL},
            'firstName' => $this->user->{User::FIRST_NAME},
            'lastName' => $this->user->{User::LAST_NAME},
            'role' => $this->user->{User::ROLE},
        ];
    }
}
