<?php

namespace App\Exceptions;

use Exception;

class ConfigNotExistsException extends Exception
{
    private const  MESSAGE = 'Config does not exists';
    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
