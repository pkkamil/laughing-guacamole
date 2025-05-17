<?php

namespace App\Http\Modules\Products\Requests;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    public function validate(): void
    {
        //
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function validated(): array
    {
        return $this->data;
    }
}
