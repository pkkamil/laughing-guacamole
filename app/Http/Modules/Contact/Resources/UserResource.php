<?php

namespace App\Http\Modules\Contact\Resources;

use App\Http\Resources\Resource;
use App\Models\User;

class UserResource extends Resource
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
            'email' => $this->user->{User::EMAIL},
            'firstName' => $this->user->{User::FIRST_NAME},
            'lastName' => $this->user->{User::LAST_NAME},
            'role' => $this->user->{User::ROLE},
        ];
    }
}
