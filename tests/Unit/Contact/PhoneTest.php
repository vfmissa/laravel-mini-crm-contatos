<?php

namespace Tests\Unit\Contact;

use PHPUnit\Framework\TestCase; 
use App\Domain\Contact\ValueObjects\Phone;
use InvalidArgumentException;

class PhoneTest extends TestCase
{
public function test_identifica_ddd_SP()
    {

        $telefone11 = new Phone('11988887777');
        $this->assertTrue($telefone11->isFromSaoPaulo());
        
        $telefone19 = new Phone('19988887777');
        $this->assertTrue($telefone19->isFromSaoPaulo());
    }

    public function test_identifica_ddd_de_outros_estados()
    {
        $telefone21 = new Phone('21988887777');      
        
        $this->assertFalse($telefone21->isFromSaoPaulo());
    }

    public function test_telefone_invalido()
    {

        $numeroInvalido = '12345'; 
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('O formato do telefone é inválido.');

        new Phone($numeroInvalido);
    }
}