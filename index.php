<?php
require_once 'vendor/autoload.php';

use App\DTO\RowDTO;
use App\FileReader;
use App\Helpers\CommissionHelper;
use App\Helpers\ConfigReaderFromIni;
use App\Helpers\RoundHelper;
use App\Parser\TextParser;
use App\Services\Collections\RatesCollection;
use App\Services\ConfigService;
use App\Services\Factory\BinInfoFactory;
use App\Services\Factory\ExchangerFactory;
use App\Services\RateService;
use GuzzleHttp\Client;

$config = new ConfigService();

try {
    $config->setConfig(ConfigReaderFromIni::readConfig('config/config.ini'));

    $filePath = __DIR__.DIRECTORY_SEPARATOR.$argv[1];

    $parser = new TextParser($filePath);

    $fileReader = new FileReader($parser);

    $httpClient = new Client();

    $exchanger = ExchangerFactory::getExchanger($config, $httpClient);

    $ratesCollections = new RatesCollection();

    $exchanger->loadRates($ratesCollections);

    $binInformer = BinInfoFactory::getBinInformer($config, $httpClient);

    $rateService = new RateService($ratesCollections);

    foreach ($fileReader->read() as $idx => $row) {
        $rowModel = RowDTO::toRowModel($row);

        $binInfo = $binInformer->getBinInfo($rowModel->getBin());
        $commission = CommissionHelper::getCommission($binInfo);

        $amount = $rateService->getAmount($rowModel);
        echo RoundHelper::ceilAmount($amount*$commission);
        print "\n";
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
    print "\n";
}
