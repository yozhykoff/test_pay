<?php

namespace App\Services\Factory;

use App\Exceptions\ConfigException;
use App\Services\BinInfo\BinInfoInterface;
use App\Services\ConfigService;
use GuzzleHttp\Client;

class BinInfoFactory extends BaseFactory
{
    protected static string $namespace = 'App\Services\BinInfo';

    /**
     * @throws ConfigException
     */
    public static function getBinInformer(ConfigService $config, Client $httpClient): BinInfoInterface
    {
        $binInfoName = self::getObjectName($config->getBinList());
        /** @var BinInfoInterface $exchanger */
        return new $binInfoName(
            $config->getConfigSection($config->getBinList()),
            $httpClient
        );
    }
}
