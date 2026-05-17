<?php

namespace App\Domain\Contact\Repositories;

use App\Domain\Contact\Entities\Contact;


interface ContactRepositoryInterface
{

    public function save(Contact $contact): void;

    public function paginate(int $perPage = 5);

    public function findById(int $id): ?Contact;

    public function deleteById(string $id): void;
}