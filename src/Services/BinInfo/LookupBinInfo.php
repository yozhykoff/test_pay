<?php

namespace App\Services\BinInfo;

use App\Exceptions\BinInfoNotExistsException;
use App\Exceptions\ConfigException;
use App\Models\BinInfoModel;
use Throwable;

class LookupBinInfo extends AbstractBinInfo implements BinInfoInterface
{
    private const CONFIG_URL_NAME = 'url';

    /**
     * @throws BinInfoNotExistsException
     */
    public function getBinInfo(string $bin): BinInfoModel
    {
        try {
            $url = $this->config[self::CONFIG_URL_NAME].'/'.$bin;
            $response = $this->httpClient->request('GET', $url);
            $body = $response->getBody()->getContents();

            if (!$body) {
                throw new BinInfoNotExistsException();
            }
            $binResults = json_decode($body);

            if (!property_exists($binResults->country, 'alpha2')) {
                throw new BinInfoNotExistsException();
            }
            $binInfo = new BinInfoModel();
            $binInfo->setAlpha2($binResults->country->alpha2);

            return $binInfo;
        } catch (Throwable) {
            throw new BinInfoNotExistsException();
        }
    }

    protected function validateConfig(): void
    {
        if (!isset($this->config[self::CONFIG_URL_NAME])) {
            throw new ConfigException(self::CONFIG_URL_NAME);
        }
    }
}
