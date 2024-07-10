<?php

namespace Exchanger;

use App\Services\Collections\RatesCollection;
use App\Services\ConfigService;
use App\Services\Exchanger\ExchangeRatesApi;
use App\Services\Factory\ExchangerFactory;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

#[CoversClass(ExchangeRatesApi::class)]
class ExchangerRatesApiTest extends TestCase
{
    public $httpClientMock;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->httpClientMock = $this->createMock(Client::class);
    }

    #[CoversFunction('loadRates')]
    public function testLoadRates()
    {
        $config = [
            'exchanger' => [
                'name' => 'exchangeRatesApi',
            ],
            'exchangeRatesApi' => [
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
    "AED": 3.986585,
    "AFN": 76.958039,
    "ALL": 100.260473
  },
  "success": true,
  "timestamp": 1720351984
}';
        $streamMock = $this->createMock(Stream::class);
        $streamMock
            ->expects($this->once())
            ->method('getContents')
            ->willReturn($exchange);

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

        $rates = [
            "AED" => 3.986585,
            "AFN" => 76.958039,
            "ALL" => 100.260473,
        ];
        foreach ($rates as $country => $rate) {
            $this->assertEquals($ratesCollections->getRateByCurrency($country)->getRate(), $rate);
        }
    }
}
