<?php

namespace App\Infrastructure\Contact\Repositories;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Entities\Contact as ContactEntity;
use App\Models\Contact as ContactModel;

class ContactRepository implements ContactRepositoryInterface
{
    public function save(ContactEntity $contact): void
    {

        ContactModel::updateOrCreate(
            ['id' => $contact->getId()],
            [

                'status'       => $contact->getStatus(),
                'score'        => $contact->getScore(),
                'processed_at' => $contact->getProcessedAt(),
                

            ]
        );
    }
}