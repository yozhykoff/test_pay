<?php

namespace App\Helpers;

use App\Exceptions\ConfigNotExistsException;

class ConfigReaderFromIni
{
    /**
     * @throws ConfigNotExistsException
     */
    public static function readConfig(string $fileName): bool|array
    {
        if (!file_exists($fileName)) {
            throw new ConfigNotExistsException();
        }

        return parse_ini_file($fileName, true);
    }
}
