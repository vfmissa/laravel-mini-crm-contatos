<?php

namespace Tests\Unit\Domain\Contact\Services;

use PHPUnit\Framework\TestCase; // Classe da biblioteca PHPUnit
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\ValueObjects\Phone;
use App\Domain\Contact\Services\ScoreCalculator;
use App\Domain\Contact\Scores\NameScore;
use App\Domain\Contact\Scores\EmailScore;
use App\Domain\Contact\Scores\PhoneScore;

class ScoreCalculatorTest extends TestCase
{
    public function test_calcula_score_total()
    {
        $nomeScore = new NameScore();
        $emailScore = new EmailScore();
        $phoneScore = new PhoneScore();

        //10 pontos
        $nome = new Nome('teste da Silva.'); 
        //30 pontos
        $email = new Email('contato@minhaempresa.com.br'); 
        //+20
        $telefone = new Phone('11988887777');

        $calculator = new ScoreCalculator($nomeScore, $emailScore, $phoneScore);
        
         // total 60 pontos
        $scoreTotal = $calculator->calculate($nome, $email, $telefone);

        $this->assertSame(60, $scoreTotal);
    }
}