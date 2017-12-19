<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class NoticeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'NoticeService';
    }
}