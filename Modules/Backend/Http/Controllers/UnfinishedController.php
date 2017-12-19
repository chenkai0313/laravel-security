<?php
/**
 * 代办事务
 * Author: CK
 * Date: 2017/11/3
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UnfinishedController extends Controller
{

    /**
     * 全部事务列表
     */
    public function affairAll(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $params['level'] = get_r_level();
        $result = \UnfinishedService::allReport($params);
        return $result;
    }
    /**
     * 全部事务列表
     */
    public function finishReport(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \UnfinishedService::finishReport($params);
        return $result;
    }
//    /**
//     * 代办事务列表
//     */
//    public function finishedAll(Request $request)
//    {
//        $params = $request->all();
//        $params['admin_id'] = get_admin_id();
//        $params['level'] = get_r_level();
//        $result = \UnfinishedService::unfinshedReport($params);
//        return $result;
//    }
    /**
     * 未处理事务列表
     */
    public function unfinishedAll(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \UnfinishedService::unfinshedReport($params);
        return $result;
    }
    /**
     * 已处理事务列表
     */
    public function overReport(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \UnfinishedService::overReport($params);
        return $result;
    }
    /**
     * 未处理事务个数
     */
    public function unfinishReportCount(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $params['level'] = get_r_level();
        $result = \UnfinishedService::unfinishReportCount($params);
        return $result;
    }

}