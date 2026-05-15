<?php

namespace Tests\Unit\Domain\Contact\Services;

use PHPUnit\Framework\TestCase;
use App\Domain\Contact\ValueObjects\Phone;
use App\Domain\Contact\Scores\PhoneScore;

class PhoneScoreTest extends TestCase
{
    public function test_calcula_vinte_pontos_para_telefone_de_sao_paulo()
    {
    
        $telefoneSP = new Phone('11988887777');
        $strategy = new PhoneScore();

        $this->assertSame(20, $strategy->calculate($telefoneSP));
    }

    public function test_calcula_dez_pontos_para_telefone_de_outros_estados()
    {
        $telefoneRJ = new Phone('21988887777');
        $strategy = new PhoneScore();

        $this->assertSame(10, $strategy->calculate($telefoneRJ));
    }
}