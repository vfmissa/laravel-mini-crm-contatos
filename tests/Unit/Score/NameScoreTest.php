<?php

namespace Tests\Unit\Domain\Contact\Score;

use PHPUnit\Framework\TestCase;
use App\Domain\Contact\ValueObjects\Nome;
use App\Domain\Contact\Scores\NameScore;

class NameScoreTest extends TestCase
{
    public function test_calcula_dez_pontos_para_nome_completo()
    {
        
        $nome = new Nome('Nome da Silva'); 
        $strategy = new NameScore();
        $this->assertSame(10, $strategy->calculate($nome));
    }

    public function test_calcula_zero_pontos_para_nome_simples()
    {
        $nome = new Nome('NomeSimples');
        $strategy = new NameScore();

        $this->assertSame(0, $strategy->calculate($nome));
    }
}