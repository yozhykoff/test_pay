<?php

use App\Exceptions\ConfigException;
use App\Services\ConfigService;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigService::class)]
class ConfigServiceTest extends TestCase
{
    #[CoversFunction('getExchanger')]
    public function testGetExchangerSuccess()
    {
        $exchangerName = 'exchangeRatesApi';
        $config = [
            'exchanger' => [
                'name' => $exchangerName
                ]
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);
        $this->assertEquals($configService->getExchanger(), $exchangerName);
    }

    #[CoversFunction('getExchanger')]
    public function testGetExchangerException()
    {
        $config = [
            'someOtherName' => [
                'name' => 'otherName'
            ]
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage('Config exchanger does not configured');
        $configService->getExchanger();
    }

    #[CoversFunction('getBinList')]
    public function testGetBinListSuccess()
    {
        $binListName = 'LookupBinInfo';
        $config = [
            'binList' => [
                'name' => $binListName
            ]
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);
        $this->assertEquals($configService->getBinList(), $binListName);
    }

    #[CoversFunction('getBinList')]
    public function testGetBinListException()
    {
        $config = [
            'someOtherName' => [
                'name' => 'otherName'
            ]
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);
        $this->expectException(ConfigException::class);
        $this->expectExceptionMessage('Config binList does not configured');
        $configService->getBinList();
    }

    #[CoversFunction('getConfigSection')]
    public function testGetConfigSectionSuccess()
    {
        $sectionName = 'sectionName';
        $config = [
            $sectionName => [
                'key1' => 'Value1',
                'key2' => 'Value2',
            ]
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);
        $this->assertEquals($configService->getConfigSection($sectionName), $config[$sectionName]);
    }
}