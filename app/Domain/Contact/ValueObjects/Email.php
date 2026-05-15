<?php

namespace App\Domain\Contact\ValueObjects;

use InvalidArgumentException;

class Email
{
    private string $address;
    
    private const PUBLIC_DOMAINS = ['@gmail.', '@hotmail.', '@yahoo.'];

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

    public function isCorporate(): bool
    {
        foreach (self::PUBLIC_DOMAINS as $publicDomain) {
            
            if (str_contains($this->address, $publicDomain)) {
                return false;
            }
        }

        return true;
    }

    public function endsWithBr(): bool
    {
        return str_ends_with($this->address, '.br');
    }
}