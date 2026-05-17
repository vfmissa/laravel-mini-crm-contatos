<?php

namespace App\Application\Contact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Entities\Contact;
use Exception;

class GetContactbyID
{
    private ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id): Contact
    {
        $contact = $this->repository->findById($id);

        if (!$contact) {
            throw new Exception("Contato não encontrado.");
        }

        return $contact;
    }
}