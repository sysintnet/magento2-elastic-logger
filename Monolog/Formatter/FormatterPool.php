<?php

namespace Sysint\ElasticLogger\Monolog\Formatter;

class FormatterPool
{
    /** @var FormatterPoolInterface[] */
    private array $formatters;

    /**
     * @param array $formatters
     */
    public function __construct(array $formatters)
    {
        $this->formatters = $formatters;
    }

    /**
     * Execute function
     * @param array $record
     * @return void
     */
    public function execute(array &$record)
    {
        foreach ($this->formatters as $formatter) {
            $formatter->formatRecord($record);
        }
    }
}
