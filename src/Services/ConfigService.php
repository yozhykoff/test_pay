<?php

namespace App\Services;

use App\Enums\ConfigKeysEnum;
use App\Enums\ConfigSectionsEnum;
use App\Exceptions\ConfigException;

class ConfigService
{
    private array $config;

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }

    /**
     * @throws ConfigException
     */
    public function getExchanger(): string
    {
        $this->checkConfigSectionExists(ConfigSectionsEnum::exchanger->name);

        return $this->config[ConfigSectionsEnum::exchanger->name][ConfigKeysEnum::name->name];
    }

    /**
     * @throws ConfigException
     */
    public function getBinList(): string
    {
        $this->checkConfigSectionExists(ConfigSectionsEnum::binList->name);

        return $this->config[ConfigSectionsEnum::binList->name][ConfigKeysEnum::name->name];
    }

    /**
     * @throws ConfigException
     */
    public function getConfigSection(string $section): array
    {
        $this->checkConfigSectionExists($section);

        return $this->config[$section];
    }

    /**
     * @throws ConfigException
     */
    private function checkConfigSectionExists(string $section): void
    {
        if (!isset($this->config[$section])) {
            throw new ConfigException($section);
        }
    }
}
