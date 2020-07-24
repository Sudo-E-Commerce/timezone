<?php

namespace Sudo\Timezone\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class AssetsFacade.
 *
 * @since 22/07/2015 11:25 PM
 */
class TimezoneFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \Sudo\Timezone\MyClass\Timezone::class;
    }
}
