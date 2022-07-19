# Elastic Logger

## Setup

Add to the file `env.php` the next section

```php
'log' => [
    'type' => '\\Sysint\\ElasticLogger\\Monolog\\Logger',
    'args' => []
]
```
