<?php

namespace App\Exceptions;

use Exception;

class BinInfoNotExistsException extends Exception
{
    private const  MESSAGE = 'Can not load bin info';
    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
