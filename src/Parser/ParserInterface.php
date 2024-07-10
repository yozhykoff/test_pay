<?php

namespace App\Parser;

interface ParserInterface
{
    public function __construct(string $fileName);

    public function hasNextLine(): bool;

    public function getLine(): string;
}
