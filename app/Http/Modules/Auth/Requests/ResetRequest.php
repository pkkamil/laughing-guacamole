<?php

namespace App\Http\Modules\Auth\Requests;

use App\Http\Requests\Request;

class ResetRequest extends Request
{
    public function validate(): void
    {
        if (empty($this->data['email'])) $this->errors['email'] = 'E-mail jest wymagany.';
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
