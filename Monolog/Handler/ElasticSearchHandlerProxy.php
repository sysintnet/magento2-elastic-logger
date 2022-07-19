<?php

namespace Sysint\ElasticLogger\Monolog\Handler;

use Magento\Framework\App\ObjectManager;
use Sysint\ElasticLogger\Service\Configuration;
use Sysint\ElasticLogger\Monolog\Formatter\ElasticaFormatterFacade;

use Elastica\Client;
use Monolog\Handler\ElasticSearchHandler;
use Monolog\Logger;

class ElasticSearchHandlerProxy
{
    /** @var Configuration */
    private Configuration $configuration;

    /** @var bool */
    private bool $isHandled = false;

    /**
     * @param Configuration|null $configuration
     */
    public function __construct(Configuration $configuration = null)
    {
        $this->configuration = $configuration ?: ObjectManager::getInstance()->get(Configuration::class);
    }

    /**
     * Is handled
     * @return bool
     */
    public function isHandled() : bool
    {
        return $this->isHandled;
    }

    /**
     * Set flag
     * @param bool $flag
     * @return void
     */
    public function setIsHandled(bool $flag)
    {
        $this->isHandled = $flag;
    }

    /**
     * Is Enabled
     * @param int $level
     * @return bool
     */
    public function isEnabled(int $level) : bool
    {
        return in_array($level, $this->configuration->getLogLevels()) === true
            && $this->configuration->isEnabled();
    }

    /**
     * Execute
     * @param int $level
     * @return ElasticSearchHandler
     */
    public function execute(int $level = Logger::DEBUG): ElasticSearchHandler
    {
        $options = [
            'index' => $this->configuration->getIndex(),
            'type' => 'stream',
            'ignore_error' => false
        ];
        $config = [
            'host' => $this->configuration->getHost(),
            'port' => $this->configuration->getPort(),
            'username' => $this->configuration->getUsername(),
            'password' => $this->configuration->getPassword()
        ];

        $client = new Client($config);

        $elasticSearchHandler = new ElasticSearchHandler($client, $options, $level);
        $formatter = new ElasticaFormatterFacade($options['index'], $options['type']);

        $elasticSearchHandler->setFormatter($formatter);

        return $elasticSearchHandler;
    }
}
