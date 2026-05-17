<?php

namespace Tests\Unit\Score;

use Tests\TestCase;
use App\Jobs\ContactScoreJob;
use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Services\ScoreCalculator;
use App\Domain\Contact\Events\EventDispatcherInterface;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use App\Events\ContactScoreEvent;

class ContactScoreJobTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_job_deve_calcular_score_salvar_e_disparar_evento(): void
    {
  
        $databaseId = 1;
        $nome = new Nome('Maria Silva');
        $email = new Email('maria@exemplo.com');
        $phone = new Phone('11999998888');
        
        $contact = new Contact('uuid-maria', $nome, $email, $phone);
        $contact->setDatabaseId($databaseId);

        $repositoryMock = $this->createMock(ContactRepositoryInterface::class);
        $calculatorMock = $this->createMock(ScoreCalculator::class);
        $dispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $repositoryMock->expects($this->once())->method('findById')->with($databaseId)->willReturn($contact);

        $calculatorMock->expects($this->once())->method('calculate')->with($nome, $email, $phone)->willReturn(85);

        $repositoryMock->expects($this->any())->method('save')->with($contact);
        $dispatcherMock->expects($this->once())->method('dispatch')->with($this->isInstanceOf(ContactScoreEvent::class));
        

        $job = new ContactScoreJob($databaseId);
        

        $job->handle($repositoryMock, $calculatorMock, $dispatcherMock);
    }
}