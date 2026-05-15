<?php

namespace App\Domain\Contact\ValueObjects;

use InvalidArgumentException;

class Email
{
    private string $address;
    
    // Definimos os domínios públicos que não são considerados corporativos
    private const PUBLIC_DOMAINS = ['gmail.com', 'hotmail.com', 'yahoo.com'];

    public function __construct(string $address)
    {
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Formato de e-mail inválido');
        }

        $this->address = $address;
    }

    public function getValue(): string
    {
        return $this->address;
    }

    // Verifica se a parte após o "@" NÃO está na lista de domínios públicos
    public function isCorporate(): bool
    {
        $domain = explode('@', $this->address)[1];
        
        return !in_array($domain, self::PUBLIC_DOMAINS);
    }

    // Utiliza uma função nativa do PHP 8+ para verificar o final da string
    public function endsWithBr(): bool
    {
        return str_ends_with($this->address, '.br');
    }
}