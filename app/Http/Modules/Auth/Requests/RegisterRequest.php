<?php

namespace App\Http\Modules\Auth\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function validate(): void
    {
        if (empty($this->data['firstName'])) $this->errors['firstName'] = 'Imię jest wymagane.';
        if (empty($this->data['lastName'])) $this->errors['lastName'] = 'Nazwisko jest wymagane.';
        if (empty($this->data['email'])) $this->errors['email'] = 'E-mail jest wymagany.';
        if (empty($this->data['password'])) $this->errors['password'] = 'Hasło jest wymagane.';
        if (($this->data['password'] ?? '') !== ($this->data['confirmedPassword'] ?? '')) $this->errors['password'] = 'Hasła muszą się zgadzać.';
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
