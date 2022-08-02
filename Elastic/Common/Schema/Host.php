<?php

namespace Sysint\ElasticLogger\Elastic\Common\Schema;

use Magento\Store\Model\StoreManagerInterface;

class Host implements SchemaInterface
{
    /** @var StoreManagerInterface */
    private StoreManagerInterface $storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(StoreManagerInterface $storeManager)
    {
        $this->storeManager = $storeManager;
    }

    /**
     * Returns fileds
     * @return array
     */
    public function getFields(): array
    {
        return [
            'host.domain' => $this->getHostDomain(),
            'host.architecture' => php_uname('m'),
            'host.hostname' => php_uname('n'),
            'host.os' => php_uname('s')
        ];
    }

    /**
     * Host domain
     * @return string
     */
    private function getHostDomain() : string
    {
        try {
            // phpcs:ignore Magento2.Functions.DiscouragedFunction
            $parsedUrl = parse_url($this->storeManager->getStore()->getBaseUrl());
            return $parsedUrl['host'] ?? '';
        } catch (\Exception $exception) {
            //
        }
        return '';
    }
}
