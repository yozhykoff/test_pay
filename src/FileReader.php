<?php

namespace App;

use Generator;
use App\Parser\ParserInterface;

readonly class FileReader
{
    public function __construct(private ParserInterface $reader) {}

    public function read(): Generator
    {
        while ($this->reader->hasNextLine()) {
            yield $this->reader->getLine();
        }
    }
}
