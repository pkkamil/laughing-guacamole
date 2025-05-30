<?php

namespace App\Http\Modules\Cart\Requests;

use App\Http\Requests\Request;

class AddToCartRequest extends Request
{
    protected array $data = [];
    public function validate(): void
    {
        $this->errors = [];
        $this->data = $_POST;

        if (empty($this->data['productId'])) {
            $this->errors['productId'] = 'ID produktu jest wymagane.';
        } else {
            $this->data['productId'] = $this->data['productId'];
        }

        if (empty($this->data['quantity']) || !is_numeric($this->data['quantity'])) {
            $this->errors['quantity'] = 'Ilość jest wymagana.';
        } else {
            $this->data['quantity'] = (int) $this->data['quantity'];
        }

        if ($this->data['quantity'] <= 0) {
            $this->errors['quantity'] = 'Ilość musi być większa od zera.';
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
