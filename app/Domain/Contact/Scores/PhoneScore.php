<?php

namespace App\Domain\Contact\Scores;

use App\Domain\Contact\ValueObjects\Phone;

class PhoneScore
{
    public function calculate(Phone $phone): int
    {
        
        if ($phone->isFromSaoPaulo()) {
            return 20;
        }
        return 10;
    }
}