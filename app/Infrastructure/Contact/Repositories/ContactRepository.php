<?php

namespace App\Infrastructure\Contact\Repositories;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Entities\Contact as ContactEntity;
use App\Models\Contact as ContactModel;

class ContactRepository implements ContactRepositoryInterface
{
    public function save(ContactEntity $contact): void
    {
        
        if ($contact->getDatabaseId() === null) {
            
            $model = ContactModel::create([
                'name'         => $contact->getName()->getValue(),
                'email'        => $contact->getEmail()->getValue(),
                'phone'        => $contact->getPhone()->getValue(),
                'status'       => $contact->getStatus(),
                'score'        => $contact->getScore() ?? 0,
                'processed_at' => $contact->getProcessedAt(),
            ]);

            $contact->setDatabaseId($model->id);
            
        } else {
            
            ContactModel::where('id', $contact->getDatabaseId())->update([
                'status'       => $contact->getStatus(),
                'score'        => $contact->getScore() ?? 0,
                'processed_at' => $contact->getProcessedAt(),
            ]);
            
        }
    }
}