# Magento 2 Elastic Log Extension

## Overview
Magento 2 Elastic Log Extension is an open-source module that enhances your Magento 2 store's diagnostic capabilities. It integrates directly with Elasticsearch, providing an easy-to-navigate user interface using Kibana dashboards for efficient log analysis.

By using this module, system administrators and developers can conveniently monitor, troubleshoot, and analyze the Magento system's behavior through in-depth log insights. It's designed to improve the overall system observability, making it easier for teams to ensure optimal performance, identify potential issues, and speed up debugging processes.

## How to install

```shell
composer require sysintnet/magento2-elastic-logger
```

Add to the file `app/etc/env.php` the next section

```php
'log' => [
    'type' => '\\Sysint\\ElasticLogger\\Monolog\\Logger',
    'args' => []
]
```

## Key Features
1. Log Streaming: Seamlessly streams Magento logs to Elasticsearch, removing the need to access the server directly for log information.
2. Kibana Dashboard: Easily view and navigate your logs using intuitive Kibana dashboards. This enables users to visualize data and draw insights at a glance.
3. Real-time Monitoring: Get near real-time updates on your logs and track your Magento 2 store's activity effectively.
4. Filtering and Searching: Offers robust log filtering and searching capabilities to easily locate specific log entries.
5. Scalability and Performance: Optimized for scalability and performance, ensuring that even high traffic Magento stores can handle log processing with minimal impact on system resources.
6. Easy to Install and Configure: The module follows Magento's coding practices, making it easy to install, upgrade, and configure based on your store's needs.

## Compatibility
This extension is compatible with Magento 2.3.x, 2.4.x and the latest versions of Elasticsearch and Kibana up to the date of the last update.


## License
This project is open-sourced software licensed under the MIT license.

## Contribution
Any contribution to the development of Magento 2 Elastic Log Extension is highly welcome. The contribution process is outlined in the CONTRIBUTING.md file.

Please note - By contributing to this project, you grant a world-wide, royalty-free, perpetual, irrevocable, non-exclusive, transferable license to use.

We look forward to your contribution and involvement in the development of this exciting project!
