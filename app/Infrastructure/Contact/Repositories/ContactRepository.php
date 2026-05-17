<?php

namespace App\Infrastructure\Contact\Repositories;

use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Entities\Contact as ContactEntity;
use App\Models\Contact as ContactModel;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;

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

    public function paginate(int $perPage = 5)
    {
        $paginator = ContactModel::paginate($perPage);

        $paginator->getCollection()->transform(function ($model) {
           
            return $this->toDomain($model); 
        });

        return $paginator;
    }

    private function toDomain(ContactModel $model): ContactEntity
    {
        return new ContactEntity(
            $model->id,
            new Nome($model->name), 
            new Email($model->email), 
            new Phone($model->phone),
            $model->status,
            $model->score
        );
    }

    public function findById(string $id): ?ContactEntity
    {
        $model = ContactModel::find($id);
        if (!$model) {
            return null;
        }
        return $this->toDomain($model);
    }
}