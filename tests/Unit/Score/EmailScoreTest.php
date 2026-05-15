<?php

namespace Tests\Unit\Domain\Contact\Services;

use PHPUnit\Framework\TestCase;
use App\Domain\Contact\ValueObjects\Email;
use App\Domain\Contact\Scores\EmailScore;

class EmailScoreTest extends TestCase
{
    public function test_calcula_pontuacao_maxima_corporativo_e_br()
    {
        
        $email = new Email('contato@minhaempresa.com.br');
        $score = new EmailScore();        
        $this->assertSame(30, $score->calculate($email));
    }

    public function test_calcula_pontuacao_apenas_corporativo()
    {
        $email = new Email('contato@minhaempresa.com');
        $score = new EmailScore();

        $this->assertSame(20, $score->calculate($email));
    }

    public function test_calcula_pontuacao_apenas_br()
    {
        $email = new Email('victor@gmail.com.br');
        $score = new EmailScore();

        $this->assertSame(10, $score->calculate($email));
    }

    public function test_calcula_pontuacao_zero_para_email_publico_internacional()
    {
        $email = new Email('victor@gmail.com');
        $score = new EmailScore();

        $this->assertSame(0, $score->calculate($email));
    }
}