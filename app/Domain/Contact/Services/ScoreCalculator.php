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
  private NameScore $nameScore;
  private EmailScore $emailScore;
  private PhoneScore $phoneScore;

  public function __construct(
      NameScore $nameScore, 
      EmailScore $emailScore, 
      PhoneScore $phoneScore
  )
  {
      $this->nameScore = $nameScore;
      $this->emailScore = $emailScore;
      $this->phoneScore = $phoneScore;
  }

    public function calculate(Nome $nome, Email $email, Phone $phone): int
    {
        $totalScore = 0;

        $totalScore += $this->nameScore->calculate($nome);
        $totalScore += $this->emailScore->calculate($email);
        $totalScore += $this->phoneScore->calculate($phone);

        return $totalScore;
    }
}