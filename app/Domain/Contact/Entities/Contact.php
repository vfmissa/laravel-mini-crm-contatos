<?php

namespace App\Domain\Contact\Entities;
use App\Domain\Contact\Enums\ContactStatus;
use App\Domain\Contact\Events\ContactScoreProcessed;
use DateTimeImmutable;

class Contact
{
    private string $id;
    private ContactStatus $status;
    private ?int $score = null;
    private ?DateTimeImmutable $processedAt = null;
    private array $domainEvents = [];

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->status = ContactStatus::PENDING;
    }

    public function getId(): string
    {
        return $this->id;
    }

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
}