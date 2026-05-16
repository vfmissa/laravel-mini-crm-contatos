<?php

namespace App\Application\Contact;

use App\Domain\Contact\Services\ScoreCalculator;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Events\EventDispatcherInterface;
use App\Domain\Contact\Entities\Contact;

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
        sleep(2); 

        try {
        
            $score = $this->calculator->calculate(
                $contact->getName(), 
                $contact->getEmail(), 
                $contact->getPhone()
            );
            
            $contact->approveScore($score);

        } catch (\Throwable $exception) {
            $contact->failProcess();
            // throw $exception;
            
        } finally {
            
            $this->repository->save($contact);
            
            foreach ($contact->pullDomainEvents() as $event) {
                $this->dispatcher->dispatch($event); 
            }
        }
    }
}