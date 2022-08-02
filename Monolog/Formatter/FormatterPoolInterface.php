<?php

namespace Sysint\ElasticLogger\Monolog\Formatter;

interface FormatterPoolInterface
{
    /**
     * Record formatting
     * @param array $record
     * @return void
     */
    public function formatRecord(array &$record) : void;
}
