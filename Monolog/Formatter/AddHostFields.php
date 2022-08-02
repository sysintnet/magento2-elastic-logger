<?php

namespace Sysint\ElasticLogger\Monolog\Formatter;

use Sysint\ElasticLogger\Elastic\Common\Schema\Host as HostInformation;

class AddHostFields implements FormatterPoolInterface
{
    /** @var HostInformation */
    private HostInformation $host;

    /**
     * @param HostInformation $host
     */
    public function __construct(HostInformation $host)
    {
        $this->host = $host;
    }

    /**
     * Record formatting
     * @param array $record
     * @return void
     */
    public function formatRecord(array &$record): void
    {
        foreach ($this->host->getFields() as $field => $value) {
            $record[$field] = $value;
        }
    }
}
