# RedisGuzzleCache

A simple redis cache for Guzzle.  
Use with https://github.com/guzzle/cache-subscriber
  
Add the following to your composer.json:
```
{
    "require": {
        "edsi-tech/redis-guzzle-cache": "~0.2"
    }
}
```

And use like that:
```php
$client = new GuzzleHttp\Client();
CacheSubscriber::attach($client, [
    'storage' => new CacheStorage(new RedisGuzzleCache($redis, 'guzzle_cache_'))
]);
```
