<?php

namespace App\Facades;

use App\Contracts\CounterContract;
use Illuminate\Support\Facades\Facade;

/**
 * A Facade for the Counter Contract
 *
 * @method static int increment(string $key, array $tags = null)
 */
class CounterFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return CounterContract::class;
    }
}
