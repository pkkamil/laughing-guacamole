<?php

namespace App\Interfaces;

use App\Models\Contact;

interface ContactRepositoryInterface
{
    public function create(Contact $contact): void;
    public function update(Contact $contact): void;
    public function delete(Contact $contact): void;
}
