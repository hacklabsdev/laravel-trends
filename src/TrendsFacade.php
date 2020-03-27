<?php

namespace Hacklabs\Trends;

use Illuminate\Support\Facades\Facade;

class TrendsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Trends';
    }
}