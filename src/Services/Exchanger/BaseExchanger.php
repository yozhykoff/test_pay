<?php

namespace App\Services\Exchanger;

use GuzzleHttp\Client;

class BaseExchanger
{
    public function __construct(protected array $config, protected Client $httpClient)
    {
    }
}
