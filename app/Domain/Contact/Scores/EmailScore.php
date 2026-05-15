<?php

namespace App\Domain\Contact\Scores;
use App\Domain\Contact\ValueObjects\Email;

class EmailScore
{
    
    public function calculate(Email $email): int
    {
        $score = 0;

        if ($email->isCorporate()) {
            $score += 20;
        }
        if ($email->endsWithBr()) {
            $score += 10;
        }

        return $score;
    }
}