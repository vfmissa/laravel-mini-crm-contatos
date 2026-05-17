<?php

namespace Tests\Unit\Application\Contact;

use App\Application\Contact\ProcessScore;
use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Events\EventDispatcherInterface;
use App\Domain\Contact\Services\ScoreCalculator;
use Illuminate\Support\Facades\Bus;
use App\Jobs\ContactScoreJob;

use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use Tests\TestCase;


class ProcessContactTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_deve_processar_score_e_chamar_repositorio_e_eventos(): void
    {
        Bus::fake();
        $nome  = new Nome('João Silva Teste');
        $email = new Email('joao.teste@exemplo.com');
        $phone = new Phone('11988887777');

        $contact = new Contact('algum-uuid-aqui', $nome, $email, $phone);
        $contact->setDatabaseId(1);
        $repositoryMock = $this->createMock(ContactRepositoryInterface::class);

        $databaseId = 1;        
        $repositoryMock->expects($this->once())
                       ->method('findById')
                       ->with($databaseId)
                       ->willReturn($contact);

        $useCase = new ProcessScore($repositoryMock);
 
        $useCase->execute($databaseId);
        Bus::assertDispatched(ContactScoreJob::class);      
    }
}