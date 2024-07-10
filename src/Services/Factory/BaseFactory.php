<?php

namespace App\Services\Factory;

class BaseFactory
{
    protected static string $namespace = '';

    public static function getObjectName(string $name): string
    {
        return static::$namespace.'\\'.ucfirst($name);
    }
}
