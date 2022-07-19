# Elastic Logger

## Setup

### Composer
`composer require sysint/module-elastic-logger`

### Magento
Add to the file `env.php` the next section

```php
'log' => [
    'type' => '\\Sysint\\ElasticLogger\\Monolog\\Logger',
    'args' => []
]
```
