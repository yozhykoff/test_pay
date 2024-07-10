<?php

namespace App\Services\Exchanger;

use App\DTO\ExchangeRatesDTO;
use App\Exceptions\ConfigException;
use App\Services\Collections\RatesCollection;
use Throwable;

class ExchangeRatesApi extends BaseExchanger implements ExchangerInterface
{
    private const CONFIG_URL_NAME = 'url';
    private const CONFIG_ACCESS_KEY_NAME = 'access_key';

    /**
     * @throws ConfigException
     */
    public function loadRates(RatesCollection $ratesCollection): void
    {
        $this->validateConfig();
        $url = $this->config[self::CONFIG_URL_NAME].'?access_key='.$this->config[self::CONFIG_ACCESS_KEY_NAME];
        try {
            $response = $this->httpClient->request('GET', $url);
            $body = $response->getBody()->getContents();
            $rates = json_decode($body, true);
            if (!$rates['success']) {
                return;
            }

            $this->prepareRatesCollection($rates['rates'], $ratesCollection);
        } catch (Throwable) {
        }
    }

    private function prepareRatesCollection(array $rates, $ratesCollection): void
    {
        foreach ($rates as $currency => $rate) {
            $rateModel = ExchangeRatesDTO::toRateModel(['rate' => $rate]);
            $ratesCollection->addRate($currency, $rateModel);
        }
    }

    /**
     * @throws ConfigException
     */
    private function validateConfig(): void
    {
        if (!isset($this->config[self::CONFIG_URL_NAME])) {
            throw new ConfigException(self::CONFIG_URL_NAME);
        }

        if (!isset($this->config[self::CONFIG_ACCESS_KEY_NAME])) {
            throw new ConfigException(self::CONFIG_ACCESS_KEY_NAME);
        }
    }
}
