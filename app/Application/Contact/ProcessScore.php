<?php

namespace App\Application\Contact;

use App\Domain\Contact\Services\ScoreCalculator;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Events\EventDispatcherInterface;
use App\Domain\Contact\Entities\Contact;
use App\Jobs\ContactScoreJob;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use Throwable;

class ProcessScore
{
    private ScoreCalculator $calculator;
    private ContactRepositoryInterface $repository;
    private EventDispatcherInterface $dispatcher;

    public function __construct(
        ScoreCalculator $calculator,
        ContactRepositoryInterface $repository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->calculator = $calculator;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function execute(Contact $contact): void
    {
        $contact->markAsProcessing();
        $this->repository->save($contact); 

        if ($contact->getDatabaseId()) {
            
            dispatch(new ContactScoreJob($contact->getDatabaseId()));
            
        } else {
            throw new \Exception("Erro ao gerar ID do contato no banco de dados.");
        }
    }
}