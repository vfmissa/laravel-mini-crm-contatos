<?php

namespace App\Domain\Contact\Events;

class ContactScoreProcessed
{
    public readonly string $contactId;
    public readonly int $score;

    public function __construct(string $contactId, int $score)
    {
        $this->contactId = $contactId;
        $this->score = $score;
    }
}