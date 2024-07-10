<?php

namespace App\Services\Factory;

use App\Exceptions\ConfigException;
use App\Services\ConfigService;
use App\Services\Exchanger\ExchangerInterface;
use GuzzleHttp\Client;

class ExchangerFactory extends BaseFactory
{
    protected static string $namespace = 'App\Services\Exchanger';

    /**
     * @throws ConfigException
     */
    public static function getExchanger(ConfigService $config, Client $httpClient): ExchangerInterface
    {
        $exchangerName = self::getObjectName($config->getExchanger());
        /** @var ExchangerInterface $exchanger */
        $exchanger = new $exchangerName(
            $config->getConfigSection($config->getExchanger()),
            $httpClient
        );
        return $exchanger;
    }
}
