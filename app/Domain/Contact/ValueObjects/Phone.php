<?php

namespace App\Domain\Contact\ValueObjects;

use InvalidArgumentException;

class Phone
{
    private string $number;

    public function __construct(string $number)
    {

        if (!preg_match('/^[0-9]{10,11}$/', $number)) {
            throw new InvalidArgumentException('O formato do telefone é inválido.');
        }

        $this->number = $number;
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