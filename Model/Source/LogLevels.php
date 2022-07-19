<?php

namespace Sysint\ElasticLogger\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

use Monolog\Logger;

class LogLevels implements OptionSourceInterface
{
    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => Logger::API, 'label' => __('API')],
            ['value' => Logger::DEBUG, 'label' => __('DEBUG')],
            ['value' => Logger::INFO, 'label' => __('INFO')],
            ['value' => Logger::NOTICE, 'label' => __('NOTICE')],
            ['value' => Logger::WARNING, 'label' => __('WARNING')],
            ['value' => Logger::ERROR, 'label' => __('ERROR')],
            ['value' => Logger::CRITICAL, 'label' => __('CRITICAL')],
            ['value' => Logger::ALERT, 'label' => __('ALERT')],
            ['value' => Logger::EMERGENCY, 'label' => __('EMERGENCY')],
        ];

    }
}
