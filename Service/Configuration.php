<?php

namespace Sysint\ElasticLogger\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\ScopeInterface;

class Configuration
{
    /** @var string */
    private const XML_PATH_CONFIG_ENABLE = 'elastic_logger/general/enabled';

    /** @var string */
    private const XML_PATH_CONFIG_HOST = 'elastic_logger/general/host';

    /** @var string */
    private const XML_PATH_CONFIG_PORT = 'elastic_logger/general/port';

    /** @var string */
    private const XML_PATH_CONFIG_USERNAME = 'elastic_logger/general/username';

    /** @var string */
    private const XML_PATH_CONFIG_PASSWORD = 'elastic_logger/general/password';

    /** @var string */
    private const XML_PATH_CONFIG_INDEX = 'elastic_logger/general/index';

    /** @var string */
    private const XML_PATH_CONFIG_LOG_LEVELS = 'elastic_logger/general/log_levels';

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var EncryptorInterface
     */
    private EncryptorInterface $encryptor;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param EncryptorInterface $encryptor
     */
    public function __construct(ScopeConfigInterface $scopeConfig, EncryptorInterface $encryptor)
    {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
    }

    /**
     * Is enabled
     * @return bool
     */
    public function isEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Host
     * @return string
     */
    public function getHost() : string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CONFIG_HOST, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Port
     * @return string
     */
    public function getPort() : string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CONFIG_PORT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Host
     * @return string
     */
    public function getUsername() : string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CONFIG_USERNAME, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Password
     * @return string
     */
    public function getPassword() : string
    {
        return $this->encryptor->decrypt(
            $this->scopeConfig->getValue(self::XML_PATH_CONFIG_PASSWORD, ScopeInterface::SCOPE_STORE)
        );
    }

    /**
     * Index
     * @return string
     */
    public function getIndex() : string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CONFIG_INDEX, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get log levels
     * @return array
     */
    public function getLogLevels() : array
    {
        return explode(
            ',',
            $this->scopeConfig->getValue(
                self::XML_PATH_CONFIG_LOG_LEVELS,
                ScopeInterface::SCOPE_STORE
            )
        );
    }
}
