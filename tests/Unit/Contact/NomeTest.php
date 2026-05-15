<?php

namespace Tests\Unit\Contact;

use PHPUnit\Framework\TestCase;
use App\Domain\Contact\ValueObjects\Nome;
use InvalidArgumentException;

class NomeTest extends TestCase
{
    public function test_nome_completo()
    {
        $nomeCompleto = new Nome('Nome Sobrenome');
        $this->assertTrue($nomeCompleto->hasMultipleWords());
    }

    public function test_nomes_abreviado()
    {
        
        $nomeAbreviado = new Nome('Lucas S');
        $this->assertFalse($nomeAbreviado->hasMultipleWords());

        $nomeAbreviadoPonto = new Nome('Lucas S.');
        $this->assertFalse($nomeAbreviadoPonto->hasMultipleWords());
    }

    public function teste_nome_simples()
    {
        $nomeSimples = new Nome('SomenteNome');
        $this->assertFalse($nomeSimples->hasMultipleWords());
    }

    public function test_deve_lancar_excecao_para_nome_vazio()
    {
        $this->expectException(InvalidArgumentException::class);
        new Nome('   ');
    }
}