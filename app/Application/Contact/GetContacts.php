<?php

namespace App\Application\Contact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;

class GetContacts
{
    private ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $perPage = 5)
    {
        return $this->repository->paginate($perPage);
    }
}