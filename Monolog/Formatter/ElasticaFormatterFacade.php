<?php

namespace Sysint\ElasticLogger\Monolog\Formatter;

use Elastica\Document;
use Monolog\Formatter\ElasticaFormatter;


/**
 * Format a log message into an Elastica Document
 *
 * @author Jelle Vink <jelle.vink@gmail.com>
 *
 * @phpstan-import-type Record from \Monolog\Logger
 */
class ElasticaFormatterFacade extends ElasticaFormatter
{
    /** @var string */
    private const ECS_VERSION = '1.2.0';

    /** @var bool[] */
    private static array $logOriginKeys = ['file' => true, 'line' => true, 'class' => true, 'function' => true];

    /** @var bool */
    private bool $useLogOriginFromContext = true;

    /** @var array */
    private array $tags;

    /**
     * Set tags
     * @param array $tags
     * @return void
     */
    public function setTags(array $tags)
    {
        $this->tags = array_unique(array_merge($this->tags, $tags));
    }

    /**
     * {@inheritdoc}
     *
     * @link https://www.elastic.co/guide/en/ecs/1.1/ecs-log.html
     * @link https://www.elastic.co/guide/en/ecs/1.1/ecs-base.html
     * @link https://www.elastic.co/guide/en/ecs/current/ecs-tracing.html
     */
    public function format(array $record)
    {
        $inRecord = $this->normalize($record);

        // Build Skeleton with "@timestamp" and "log.level"
        $outRecord = [
            '@timestamp' => $inRecord['datetime'],
            'log.level'  => $inRecord['level_name'],
        ];

        // Add "message"
        if (isset($inRecord['message']) === true) {
            $outRecord['message'] = $inRecord['message'];
        }

        // Add "ecs.version"
        $outRecord['ecs.version'] = self::ECS_VERSION;

        // Add "log": { "logger": ..., ... }
        $outRecord['log'] = [
            'logger' => $inRecord['channel'],
        ];

        // Add Tracing Context
        if (isset($inRecord['context']['tracing']['Elastic\Types\Tracing']) === true) {
            $outRecord += $inRecord['context']['tracing']['Elastic\Types\Tracing'];
            unset($inRecord['context']['tracing']);
        }

        // Add Service Context
        if (isset($inRecord['context']['service']['Elastic\Types\Service']) === true) {
            $outRecord += $inRecord['context']['service']['Elastic\Types\Service'];
            unset($inRecord['context']['service']);
        }

        // Add User Context
        if (isset($inRecord['context']['user']['Elastic\Types\User']) === true) {
            $outRecord += $inRecord['context']['user']['Elastic\Types\User'];
            unset($inRecord['context']['user']);
        }

        $this->formatContext($inRecord['extra'], /* ref */ $outRecord);
        $this->formatContext($inRecord['context'], /* ref */ $outRecord);

        // Add ECS Tags
        if (empty($this->tags) === false) {
            $outRecord['tags'] = $this->normalize($this->tags);
        }

        return parent::format($outRecord);
    }

    private function formatContext(array $inContext, array &$outRecord): void
    {
        $foundLogOriginKeys = false;

        // Context should go to the top of the out record
        foreach ($inContext as $contextKey => $contextVal) {
            // label keys should be sanitized
            if ($contextKey === 'labels') {
                $outLabels = [];
                foreach ($contextVal as $labelKey => $labelVal) {
                    $outLabels[str_replace(['.', ' ', '*', '\\'], '_', trim($labelKey))] = $labelVal;
                }
                $outRecord['labels'] = $outLabels;
                continue;
            }

            if ($this->useLogOriginFromContext) {
                if (isset(self::$logOriginKeys[$contextKey])) {
                    $foundLogOriginKeys = true;
                    continue;
                }
            }

            $outRecord[$contextKey] = $contextVal;
        }

        if ($foundLogOriginKeys) {
            $this->formatLogOrigin($inContext, /* ref */ $outRecord);
        }
    }

    /**
     * Format log
     * @param array $inContext
     * @param array $outRecord
     * @return void
     */
    private function formatLogOrigin(array $inContext, array &$outRecord): void
    {
        $originVal = [];

        $fileVal = [];
        if (array_key_exists('file', $inContext)) {
            $fileName = $inContext['file'];
            if (is_string($fileName)) {
                $fileVal['name'] = $fileName;
            }
        }
        if (array_key_exists('line', $inContext)) {
            $fileLine = $inContext['line'];
            if (is_int($fileLine)) {
                $fileVal['line'] = $fileLine;
            }
        }
        if (!empty($fileVal)) {
            $originVal['file'] = $fileVal;
        }

        $outFunctionVal = null;
        if (array_key_exists('function', $inContext)) {
            $inFunctionVal = $inContext['function'];
            if (is_string($inFunctionVal)) {
                if (array_key_exists('class', $inContext)) {
                    $inClassVal = $inContext['class'];
                    if (is_string($inClassVal)) {
                        $outFunctionVal = $inClassVal . '::' . $inFunctionVal;
                    }
                }

                if ($outFunctionVal === null) {
                    $outFunctionVal = $inFunctionVal;
                }
            }
        }
        if ($outFunctionVal !== null) {
            $originVal['function'] = $outFunctionVal;
        }

        if (!empty($originVal)) {
            $outRecord['log']['origin'] = $originVal;
        }
    }

    /**
     * Convert a log message into an Elastica Document
     *
     * @phpstan-param Record $record
     */
    protected function getDocument($record): Document
    {
        $document = new Document();
        $document->setData($record);
        $document->setOpType('create');
        if (method_exists($document, 'setType')) {
            /** @phpstan-ignore-next-line */
            $document->setType($this->type);
        }
        $document->setIndex($this->index);

        return $document;
    }
}
