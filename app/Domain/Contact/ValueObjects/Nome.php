<?php

namespace App\Domain\Contact\ValueObjects;

use InvalidArgumentException;

class Nome
{
    private string $nome;

    public function __construct(string $nome)
    {
        $cleanedName = trim($nome);

        if (empty($cleanedName)) {
            throw new InvalidArgumentException('O nome não pode estar vazio.');
        }

        $this->nome = $cleanedName;
    }

    public function getValue(): string
    {
        return $this->nome;
    }

public function hasMultipleWords(): bool
    {
        $words = explode(' ', $this->nome);
        $connectors = ['de', 'da', 'do', 'dos', 'e'];
        $validWordsCount = 0;

        foreach ($words as $word) {
            $cleanWord = strtolower(trim($word, '.'));

            if (in_array($cleanWord, $connectors)) {
                continue;
            }
            if (mb_strlen($cleanWord) <= 1) {
                continue;
            }
            $validWordsCount++;
        }

        // Retorna verdadeiro apenas com 2 ou mais palavras no nome
        return $validWordsCount >= 2;
    }
}