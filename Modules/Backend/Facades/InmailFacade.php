<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class InmailFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'InmailService';
    }
}