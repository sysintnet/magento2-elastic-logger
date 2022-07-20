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

### Files

auth.json
```json
{
    "gitlab-token" : {
        "repo.sysint.net": {
            "username": "module-elastic-logger",
            "token": "BgCjh-CEdLzgH4_CDViL"
        }
    }
}

```


composer.json
```json
{
  "repositories": {
    "4": {
      "type": "composer",
      "url": "https://repo.sysint.net/api/v4/group/4/-/packages/composer/"
    }
  }
}
```
