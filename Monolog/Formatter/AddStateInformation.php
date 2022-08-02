<?php

namespace Sysint\ElasticLogger\Monolog\Formatter;

use Magento\Framework\App\State;

class AddStateInformation implements FormatterPoolInterface
{
    /** @var State */
    private State $state;

    /**
     * @param State $state
     */
    public function __construct(State $state)
    {
        $this->state = $state;
    }

    /**
     * Record formatting
     * @param array $record
     * @return void
     */
    public function formatRecord(array &$record): void
    {
        try {
            $record['state.mode'] = $this->state->getMode();
            $record['state.area.code'] = $this->state->getAreaCode();
        } catch (\Exception $exception) {
            //
        }
    }
}
