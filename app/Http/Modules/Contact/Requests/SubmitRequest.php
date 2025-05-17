<?php

namespace App\Http\Modules\Contact\Requests;

use App\Http\Requests\Request;

class SubmitRequest extends Request
{
    public function validate(): void
    {
        if (empty($this->data['firstName'])) $this->errors['firstName'] = 'Imię jest wymagane.';
        if (empty($this->data['lastName'])) $this->errors['lastName'] = 'Nazwisko jest wymagane.';
        if (empty($this->data['email'])) $this->errors['email'] = 'E-mail jest wymagany.';
        elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) $this->errors['email'] = 'Nieprawidłowy format e-maila.';
        if (!empty($this->data['phone']) && !preg_match('/^\+?[0-9]{1,3}?[ -]?[0-9]{1,4}?[ -]?[0-9]{1,4}?[ -]?[0-9]{1,9}$/', $this->data['phone'])) $this->errors['phone'] = 'Nieprawidłowy format numeru telefonu.';
        if (empty($this->data['message'])) $this->errors['message'] = 'Wiadomość jest wymagana.';
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
