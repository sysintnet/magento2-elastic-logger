<?php

namespace Sysint\ElasticLogger\Monolog;

use Magento\Framework\Logger\Monolog;

use Sysint\ElasticLogger\Monolog\Handler\ElasticSearchHandlerProxy;

class Logger extends Monolog
{
    /** @var array */
    private array $elasticSearchHandlerProxy = [];

    /**
     * Adds a log record.
     *
     * @param integer $level The logging level
     * @param string $message The log message
     * @param array $context The log context
     * @return bool Whether the record has been processed
     */
    public function addRecord($level, $message, array $context = [])
    {
        $newHandler = $this->getElasticSearchHandlerProxy($level);
        if ($newHandler->isEnabled($level) === true && $newHandler->isHandled() === false) {
            $this->pushHandler($newHandler->execute($level));
            $newHandler->setIsHandled(true);
        }

        return parent::addRecord($level, $message, $context);
    }

    /**
     * Returns handler by level
     * @param mixed $level
     * @return ElasticSearchHandlerProxy
     */
    private function getElasticSearchHandlerProxy($level) : ElasticSearchHandlerProxy
    {
        if (empty($this->elasticSearchHandlerProxy[$level]) === true) {
            $this->elasticSearchHandlerProxy[$level] =  new ElasticSearchHandlerProxy();
        }

        return $this->elasticSearchHandlerProxy[$level];
    }
}
