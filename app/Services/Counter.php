<?php

namespace App\Services;

use App\Contracts\CounterContract;
use Illuminate\Contracts\Cache\Factory as Cache;
use Illuminate\Contracts\Session\Session;

class Counter implements CounterContract
{
    private $timeout;
    private $cache;
    private $session;
    private $supportTags;

    public function __construct(Cache $cache, Session $session, int $timeout)
    {
        $this->cache = $cache;
        $this->timeout = $timeout;
        $this->session = $session;
        $this->supportTags = method_exists($cache, 'tags');
    }

    /**
     * Increments the views on a resource
     *
     * @param string $key
     * @param array $tags
     * @return integer
     */
    public function increment(string $key, array $tags = null): int
    {
        $sessionId = $this->session->getId();
        $counterKey = "$key-counter";
        $usersKey = "$key-users";

        $cache = $this->supportTags && $tags !== null 
            ? $this->cache->tags($tags)
            : $this->cache;

        $users = $cache->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= $this->timeout) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= $this->timeout
        ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        $cache->forever($usersKey, $usersUpdate);

        if (!$cache->has($counterKey)) {
            $cache->forever($counterKey, 1);
        } else {
            $cache->increment($counterKey, $difference);
        }

        return $cache->get($counterKey);
    }
}
