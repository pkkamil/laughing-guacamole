<?php

namespace App\Repositories;

use App\Interfaces\ContactRepositoryInterface;
use App\Repositories\Schemes\Repository;
use App\Models\Contact;

class ContactRepository extends Repository implements ContactRepositoryInterface
{
    protected string $table = Contact::TABLE_NAME;
    protected string $modelClass = Contact::class;

    public function create(Contact $contact): void
    {
        $stmt = $this->database->prepare("
            INSERT INTO {$this->table} (first_name, last_name, email, phone, message)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $contact->getFirstName(),
            $contact->getLastName(),
            $contact->getEmail(),
            $contact->getPhone(),
            $contact->getMessage(),
        ]);
    }

    public function update(Contact $contact): void
    {
        $stmt = $this->database->prepare("
            UPDATE {$this->table} SET
                first_name = ?,
                last_name = ?,
                email = ?,
                phone = ?,
                message = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $contact->getFirstName(),
            $contact->getLastName(),
            $contact->getEmail(),
            $contact->getPhone(),
            $contact->getMessage(),
            $contact->getId()
        ]);
    }

    public function delete(Contact $contact): void
    {
        $stmt = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$contact->getId()]);
    }
}
