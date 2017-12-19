<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class UnfinishedFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'UnfinishedService';
    }
}