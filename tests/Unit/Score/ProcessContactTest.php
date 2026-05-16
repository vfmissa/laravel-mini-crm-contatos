<?php

namespace Tests\Unit\Application\Contact;

use PHPUnit\Framework\TestCase;
use App\Application\Contact\ProcessScore;
use App\Domain\Contact\Entities\Contact;
use App\Domain\Contact\Repositories\ContactRepositoryInterface;
use App\Domain\Contact\Events\EventDispatcherInterface;
use App\Domain\Contact\Services\ScoreCalculator;


class ProcessContactTest extends TestCase
{
    public function test_deve_processar_score_e_chamar_repositorio_e_eventos(): void
    {
        $contact = new Contact('123');

        $repositoryMock = $this->createMock(ContactRepositoryInterface::class);
        $dispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $calculatorMock = $this->createMock(ScoreCalculator::class);

        $calculatorMock->method('calculate')->willReturn(60);

        // Expectativas (O que deve acontecer)
        $repositoryMock->expects($this->exactly(2))->method('save');
        $dispatcherMock->expects($this->once())->method('dispatch');

        // Act (Execução)
        $useCase = new ProcessScore($calculatorMock, $repositoryMock, $dispatcherMock);
        $useCase->execute($contact, 'Victor Silva', 'contato@minhaempresa.com.br', '11988887777');
    }
}