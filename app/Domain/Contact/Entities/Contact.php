<?php

namespace App\Domain\Contact\Entities;
use App\Domain\Contact\Enums\ContactStatus;
use App\Domain\Contact\Events\ContactScoreProcessed;
use DateTimeImmutable;

use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;

class Contact
{
    private string $id;
    private ContactStatus $status;
    private ?int $score = null;
    private ?DateTimeImmutable $processedAt = null;
    private array $domainEvents = [];

    private Nome $name;
    private Email $email;
    private Phone $phone;
    private ?int $databaseId = null;

    public function __construct(string $id, Nome $name, Email $email, Phone $phone)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->status = ContactStatus::PENDING;
    }

    public function getId(): string {return $this->id; }
    public function getName(): Nome { return $this->name; }
    public function getEmail(): Email { return $this->email; }
    public function getPhone(): Phone { return $this->phone; }

    public function markAsProcessing(): void
    {
        $this->status = ContactStatus::PROCESSING;
    }

    public function failProcess(): void
    {
        $this->status = ContactStatus::FAILED;
    }

    public function approveScore(int $calculatedScore): void
    {
        $this->score = $calculatedScore;
        $this->status = ContactStatus::ACTIVE;
        $this->processedAt = new DateTimeImmutable('now');
        $this->domainEvents[] = new ContactScoreProcessed($this->id, $this->score);
    }

    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    public function getStatus(): ContactStatus
    {
        return $this->status;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function getProcessedAt(): ?DateTimeImmutable
    {
        return $this->processedAt;
    }
    
    public function getDatabaseId(): ?int
    {
        return $this->databaseId;
    }

    public function setDatabaseId(int $databaseId): void
    {
        $this->databaseId = $databaseId;
    }
}