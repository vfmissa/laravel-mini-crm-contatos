<?php

namespace App\Application\Contact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use Exception;
use App\Domain\Contact\Entities\Contact;
use App\Jobs\ContactScoreJob;
use Throwable;

class ProcessScore
{
    private ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }

    public function execute(int $id): void
    {
        $contact = $this->repository->findById($id);

        if (!$contact) {
            throw new Exception("Contato não encontrado.");
        }

        if ($contact->getDatabaseId()) {
            dispatch(new ContactScoreJob($contact->getDatabaseId()));
        } else {
            throw new Exception("Erro ao gerar ID do contato no banco de dados.");
        }
    }
}