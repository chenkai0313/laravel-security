<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class AdminRecordFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AdminRecordService';
    }
}
