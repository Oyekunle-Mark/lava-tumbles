<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class Counter
{
    public function increment(string $key, array $tags = null): int
    {
        $sessionId = session()->getId();
        $counterKey = "$key-counter";
        $usersKey = "$key-users";

        $users = Cache::tags(['blog_post'])->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog_post'])->forever($usersKey, $usersUpdate);

        if (!Cache::tags(['blog_post'])->has($counterKey)) {
            Cache::tags(['blog_post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog_post'])->increment($counterKey, $difference);
        }

        return Cache::tags(['blog_post'])->get($counterKey);
    }
}
