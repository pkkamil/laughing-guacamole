<?php

namespace App\Http\Modules\Products\Requests;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    protected array $input = [];
    protected array $files = [];

    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/var/www/html/public/img/products/';

    public function validate(): void
    {
        error_log(print_r($_FILES, true));

        $this->errors = [];
        $this->data = [];
        $this->input = $_POST;
        $this->files = $_FILES;

        if (empty($this->input['name'])) {
            $this->errors['name'] = 'Nazwa produktu jest wymagana.';
        } else {
            $this->data['name'] = $this->input['name'];
        }

        if (empty($this->input['description'])) {
            $this->errors['description'] = 'Opis produktu jest wymagany.';
        } else {
            $this->data['description'] = $this->input['description'];
        }

        if (!isset($this->input['price']) || !is_numeric($this->input['price'])) {
            $this->errors['price'] = 'Cena musi być liczbą.';
        } else {
            $this->data['price'] = (float) $this->input['price'];
        }

        if (!isset($this->input['stock']) || !is_numeric($this->input['stock'])) {
            $this->errors['stock'] = 'Stan magazynowy musi być liczbą.';
        } else {
            $this->data['stock'] = (int) $this->input['stock'];
        }

        if (!empty($this->files['image']['tmp_name'])) {

            $file = $this->files['image'];

            if (!in_array($file['type'], self::SUPPORTED_TYPES)) {
                $this->errors['image'] = 'Nieobsługiwany typ pliku.';
                return;
            }

            if ($file['size'] > self::MAX_FILE_SIZE) {
                $this->errors['image'] = 'Plik jest za duży.';
                return;
            }

            $filename = uniqid() . '_' . basename($file['name']);
            $targetFile = self::UPLOAD_DIRECTORY . $filename;

            if (!is_uploaded_file($file['tmp_name'])) {
                $this->errors['image'] = 'Plik nie jest poprawnym uploadem.';
                return;
            }

            if (!is_writable(self::UPLOAD_DIRECTORY)) {
                $this->errors['image'] = 'Katalog docelowy nie ma praw zapisu.';
                return;
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                $this->data['image'] = '/img/products/' . $filename;
            } else {
                $this->errors['image'] = 'Nie udało się zapisać pliku.';
            }
        } else {
            $this->data['image'] = null;
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
