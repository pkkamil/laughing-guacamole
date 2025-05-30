<?php

namespace App\Http\Modules\Cart\Requests;

use App\Http\Requests\Request;

class UpdateQuantityRequest extends Request
{
    protected array $data = [];
    public function validate(): void
    {
        $this->errors = [];
        $this->data = $_POST;

        if (empty($this->data['cartItemId'])) {
            $this->errors['cartItemId'] = 'ID pozycji w koszyku jest wymagane.';
        } else {
            $this->data['cartItemId'] = $this->data['cartItemId'];
        }

        if (empty($this->data['quantity']) || !is_numeric($this->data['quantity']) || $this->data['quantity'] <= 0) {
            $this->errors['quantity'] = 'Ilość musi być liczbą większą niż zero.';
        } else {
            $this->data['quantity'] = (int)$this->data['quantity'];
        }
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
