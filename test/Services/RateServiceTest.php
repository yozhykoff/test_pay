<?php

use App\DTO\RowDTO;
use App\Services\Collections\RatesCollection;
use App\Services\ConfigService;
use App\Services\Factory\ExchangerFactory;
use App\Services\RateService;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

#[CoversClass(ConfigService::class)]
class RateServiceTest extends TestCase
{
    public $httpClientMock;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function setUp(): void
    {
        $this->httpClientMock = $this->createMock(Client::class);
    }

    #[CoversFunction('getAmount')]
    public function testRateRowNotEUR()
    {
        $binListName = 'LookupBinInfo';
        $exchanger = 'exchangeRatesApi';
        $config = [
            'binList' => [
                'name' => $binListName,
            ],
            $binListName => [
                'url' => 'https://lookup.binlist.net',
            ],
            'exchanger' => [
                'name' => $exchanger,
            ],
            $exchanger => [
                'url' => 'https://api.exchangeratesapi.io/latest',
                'access_key' => 'HV3zkzewHxtKTPx8zP9ukol4Y94Bfkvn',
            ],
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);

        $exchanger = ExchangerFactory::getExchanger(
            $configService,
            $this->httpClientMock
        );

        $exchange = '{
  "base": "EUR",
  "date": "2024-07-07",
  "rates": {
    "USD": 1.5
  },
  "success": true,
  "timestamp": 1720351984
}';
        $streamMock = $this->createMock(Stream::class);
        $streamMock
            ->expects($this->once())
            ->method('getContents')
            ->willReturn(
                $exchange
            );

        $responseMock = $this->createMock(Response::class);
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($streamMock);

        $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($responseMock);

        $ratesCollections = new RatesCollection();

        $exchanger->loadRates($ratesCollections);

        $rateService = new RateService($ratesCollections);

        $row = '{"bin":"45717360","amount":"75.00","currency":"USD"}';
        $rowModel = RowDTO::toRowModel($row);

        $this->assertEquals($rateService->getAmount($rowModel), 50);
    }

    #[CoversFunction('getAmount')]
    public function testRateRowEUR()
    {
        $binListName = 'LookupBinInfo';
        $exchanger = 'exchangeRatesApi';
        $config = [
            'binList' => [
                'name' => $binListName,
            ],
            $binListName => [
                'url' => 'https://lookup.binlist.net',
            ],
            'exchanger' => [
                'name' => $exchanger,
            ],
            $exchanger => [
                'url' => 'https://api.exchangeratesapi.io/latest',
                'access_key' => 'HV3zkzewHxtKTPx8zP9ukol4Y94Bfkvn',
            ],
        ];

        $configService = new ConfigService();
        $configService->setConfig($config);

        $exchanger = ExchangerFactory::getExchanger(
            $configService,
            $this->httpClientMock
        );

        $exchange = '{
  "base": "EUR",
  "date": "2024-07-07",
  "rates": {
    "USD": 1.5
  },
  "success": true,
  "timestamp": 1720351984
}';
        $streamMock = $this->createMock(Stream::class);
        $streamMock
            ->expects($this->once())
            ->method('getContents')
            ->willReturn(
                $exchange
            );

        $responseMock = $this->createMock(Response::class);
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($streamMock);

        $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->willReturn($responseMock);

        $ratesCollections = new RatesCollection();

        $exchanger->loadRates($ratesCollections);

        $rateService = new RateService($ratesCollections);

        $row = '{"bin":"45717360","amount":"75.00","currency":"EUR"}';
        $rowModel = RowDTO::toRowModel($row);

        $this->assertEquals($rateService->getAmount($rowModel), 75);
    }
}
