<?php

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;


class ReportGradeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'ReportGradeService';
    }
}