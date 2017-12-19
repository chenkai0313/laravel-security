<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class ClientInfoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ClientInfoService';
    }
}