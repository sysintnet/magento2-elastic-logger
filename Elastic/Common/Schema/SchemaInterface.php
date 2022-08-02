<?php

namespace Sysint\ElasticLogger\Elastic\Common\Schema;

interface SchemaInterface
{
    /**
     * Returns fileds
     * @return array
     */
    public function getFields() : array;
}
