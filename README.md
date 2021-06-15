# apikit
Kit for api servers

## Installation
```
composer require levkopo/apikit
```

## Example
```php
use levkopo\apikit\ApiKit;
ApiKit::create()
    ->method("hello_world", function(ApiKit $apiKit) {
        return "Hello, world!";
    })
    ->method("hwp", function(ApiKit $apiKit) {
        [$someKey] = $apiKit->params(["key"]);
        return "Key: $someKey";
    })
    ->start();
```
