<?php

namespace App\Domain\Contact\ValueObjects;

use InvalidArgumentException;

class Phone
{
    private string $number;

    public function __construct(string $number)
    {
        $cleanedNumber = preg_replace('/[^0-9]/', '', $number);
        if (!preg_match('/^[0-9]{10,11}$/', $cleanedNumber)) {
            throw new InvalidArgumentException('O formato do telefone é inválido.');
        }

        $this->number = $cleanedNumber;
    }

    public function getValue(): string
    {
        return $this->number;
    }

    public function isFromSaoPaulo(): bool
    {
        $dddString = substr($this->number, 0, 2);
        $dddInt = (int) $dddString;

        return $dddInt >= 11 && $dddInt <= 19;
    }
}