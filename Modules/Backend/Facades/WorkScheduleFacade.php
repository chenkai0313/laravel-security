<?php
/**
 * Created by PhpStorm.
 * User: yefan
 * Date: 2017/10/31
 * Time: 下午2:06
 */

namespace Modules\Backend\Facades;

use Illuminate\Support\Facades\Facade;

class WorkScheduleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return  'WorkScheduleService';
    }
}