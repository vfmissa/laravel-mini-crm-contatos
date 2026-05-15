<?php

namespace App\Domain\Contact\Services;

use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;

use App\Domain\Contact\Scores\NameScore;
use App\Domain\Contact\Scores\EmailScore;
use App\Domain\Contact\Scores\PhoneScore;

class ScoreCalculator
{

    public function calculate(Nome $nome, Email $email, Phone $phone): int
    {

        $totalScore = 0;


        $nomeScore = new NameScore();
        $emailScore = new EmailScore();
        $phoneScore = new PhoneScore();

        $totalScore += $nomeScore->calculate($nome);
        $totalScore += $emailScore->calculate($email);
        $totalScore += $phoneScore->calculate($phone);

        return $totalScore;
    }
}