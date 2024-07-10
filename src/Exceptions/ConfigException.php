<?php

namespace App\Exceptions;

use Exception;

class ConfigException extends Exception
{
    private const  MESSAGE = 'Config %s does not configured';
    public function __construct(string $part)
    {
        parent::__construct(sprintf( self::MESSAGE, $part));
    }
}
