<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class ReportFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'ReportService';
    }
}