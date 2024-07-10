<?php

namespace App\Parser;

class TextParser implements ParserInterface
{
    private $handle;

    private string $line;

    public function __construct(string $fileName)
    {
        $this->handle = fopen($fileName, "r");
    }

    #[\Override] public function hasNextLine(): bool
    {
        if (($line = fgets($this->handle)) !== false) {
            $this->line = $line;
            return true;
        }

        return false;
    }

    #[\Override] public function getLine(): string
    {
        return $this->line;
    }
}
