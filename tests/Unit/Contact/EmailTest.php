<?php

namespace Tests\Unit\Contact;

use PHPUnit\Framework\TestCase;
use App\Domain\Contact\ValueObjects\Email;
use InvalidArgumentException;

class EmailTest extends TestCase
{
    public function test_email_valido()
    {
        $enderecoValido = 'teste@teste.com.br';
        $email = new Email($enderecoValido);

        $this->assertSame($enderecoValido, $email->getValue());
    }

    public function test_email_invalido()
    {
        $enderecoInvalido = 'teste.com';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Formato de e-mail inválido');

        new Email($enderecoInvalido);
    }

    public function test_identifica_dominio_corporativo()
    {
        // E-mail corporativo (não é gmail, hotmail ou yahoo)
        $corporateEmail = new Email('teste@empresa.com');
        $this->assertTrue($corporateEmail->isCorporate());

        $gmail = new Email('teste@gmail.com');
        $this->assertFalse($gmail->isCorporate());

        $hotmail = new Email('teste@hotmail.com');
        $this->assertFalse($hotmail->isCorporate());
    }

    public function test_identifica_extensao_br()
    {
        $brEmail = new Email('teste@teste.com.br');
        $this->assertTrue($brEmail->endsWithBr());

        $comEmail = new Email('victor@teste.com');
        $this->assertFalse($comEmail->endsWithBr());
    }
}