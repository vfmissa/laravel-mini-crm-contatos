<?php

namespace App\Domain\Contact\Scores;

use App\Domain\Contact\ValueObjects\Nome;

class NameScore
{
    public function calculate(Nome $nome): int
    {
        if ($nome->hasMultipleWords()) {
            return 10;
        }

        return 0;
    }
}