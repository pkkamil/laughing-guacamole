<?php

namespace App\Models;

use App\Models\Schemes\MysqlModel;

class Contact extends MysqlModel
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private ?string $phone = null;
    private string $message;

    public const TABLE_NAME = 'contacts';

    public const FIRST_NAME = 'firstName';
    public const LAST_NAME = 'lastName';
    public const EMAIL = 'email';
    public const PHONE = 'phone';
    public const MESSAGE = 'message';

    public function getFirstName(): string
    {
        return $this->{self::FIRST_NAME};
    }

    public function setFirstName(string $firstName): void
    {
        $this->{self::FIRST_NAME} = $firstName;
    }

    public function getLastName(): string
    {
        return $this->{self::LAST_NAME};
    }

    public function setLastName(string $lastName): void
    {
        $this->{self::LAST_NAME} = $lastName;
    }

    public function getEmail(): string
    {
        return $this->{self::EMAIL};
    }

    public function setEmail(string $email): void
    {
        $this->{self::EMAIL} = $email;
    }

    public function getPhone(): ?string
    {
        return $this->{self::PHONE};
    }

    public function setPhone(?string $phone): void
    {
        $this->{self::PHONE} = $phone;
    }

    public function getMessage(): string
    {
        return $this->{self::MESSAGE};
    }

    public function setMessage(string $message): void
    {
        $this->{self::MESSAGE} = $message;
    }

    public static function fromArray(array $data): static
    {
        $contact = new static();
        $contact->setId($data['id'] ?? $data[self::ID] ?? '');
        $contact->setCreatedAt($data['created_at'] ?? $data[self::CREATED_AT] ?? '');
        $contact->setUpdatedAt($data['updated_at'] ?? $data[self::UPDATED_AT] ?? '');
        $contact->setFirstName($data['first_name'] ?? $data[self::FIRST_NAME] ?? '');
        $contact->setLastName($data['last_name'] ?? $data[self::LAST_NAME] ?? '');
        $contact->setEmail($data['email'] ?? $data[self::EMAIL] ?? '');
        $contact->setPhone($data['phone'] ?? $data[self::PHONE] ?? null);
        $contact->setMessage($data['message'] ?? $data[self::MESSAGE] ?? '');

        return $contact;
    }
}
