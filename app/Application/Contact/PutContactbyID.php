<?php

namespace App\Application\Contact;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use App\Domain\Contact\Entities\Contact;
use Exception;

class PutContactbyID
{
    private ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id, array $data): void
    {
      $contact = $this->repository->findById($id);

      if (!$contact) {
          throw new Exception("Contato não encontrado para atualização.");
      }

        Log::info('UpdateContact: Database ID resgatado', ['db_id' => $contact->getDatabaseId()]);
      
      $contact->updateDetails(
          new Nome($data['name']),
          new Email($data['email']),
          new Phone($data['phone'])
      );
      
      $this->repository->save($contact);

    }
}