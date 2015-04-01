<?php

/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 11.02.2015
 * Time: 15:04
 */

namespace MyCity\Bundle\RequestBundle\Helpers;


use Doctrine\Common\Cache\Cache;
use EdsiTech\RedisSafeClientBundle\SafeRedisClient;
use Predis\Client;

class RedisGuzzleCache implements Cache
{

    /**
     * @var SafeRedisClient
     */
    protected $redis;

    /**
     * @var string
     */
    protected $key;


    /**
     * @param Client $client
     * @param string $cacheKeyPrefix
     */
    public function __construct(Client $client, $cacheKeyPrefix)
    {
        $this->redis = new SafeRedisClient($client);
        $this->key   = $cacheKeyPrefix;
    }

    /**
     * Fetches an entry from the cache.
     *
     * @param string $id The id of the cache entry to fetch.
     *
     * @return mixed The cached data or FALSE, if no cache entry exists for the given id.
     */
    public function fetch($id)
    {
        return $this->redis->get(
            $this->key.$id,
            false
        );
    }

    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id The cache id of the entry to check for.
     *
     * @return boolean TRUE if a cache entry exists for the given cache id, FALSE otherwise.
     */
    public function contains($id)
    {
        return $this->redis->exists($this->key.$id);
    }

    /**
     * Puts data into the cache.
     *
     * @param string $id The cache id.
     * @param mixed $data The cache entry/data.
     * @param int $lifeTime The cache lifetime.
     *                         If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return boolean TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function save($id, $data, $lifeTime = 0)
    {
        return $lifeTime == 0
            ? $this->redis->set(
                $this->key.$id,
                $data
            )
            : $this->redis->setex(
                $this->key.$id,
                $lifeTime,
                $data
            )
            ;
    }

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return boolean TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    public function delete($id)
    {
        return $this->redis->del($this->key.$id);
    }

    /**
     * Retrieves cached information from the data store.
     *
     * The server's statistics array has the following values:
     *
     * - <b>hits</b>
     * Number of keys that have been requested and found present.
     *
     * - <b>misses</b>
     * Number of items that have been requested and not found.
     *
     * - <b>uptime</b>
     * Time that the server is running.
     *
     * - <b>memory_usage</b>
     * Memory used by this server to store items.
     *
     * - <b>memory_available</b>
     * Memory allowed to use for storage.
     *
     * @since 2.2
     *
     * @return array|null An associative array with server's statistics if available, NULL otherwise.
     */
    public function getStats()
    {
        // TODO: Implement getStats() method.
        return null;
    }
}
