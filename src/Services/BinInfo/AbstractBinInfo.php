<?php

namespace App\Services\BinInfo;

use App\Exceptions\ConfigException;
use GuzzleHttp\Client;

abstract class AbstractBinInfo
{
    /**
     * @throws ConfigException
     */
    public function __construct(protected array $config, protected Client $httpClient)
    {
        $this->validateConfig();
    }

    /**
     * @throws ConfigException
     */
    abstract protected function validateConfig(): void;
}
