<?php
/**
 * 登录失败记录
 * Author: CK
 * Date: 2017/12/7
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminRecordController extends Controller
{
    /**
     * 解除登录限制
     */
    public function unclogLogin(Request $request)
    {
        $params = $request->input();
        $result = \AdminRecordService::unclogLogin($params);
        return $result;
    }

    /**
     * 所有用户最后登录时间记录列表
     */
    public function recordList(Request $request)
    {
        $params = $request->input();
        $result = \AdminRecordService::recordList($params);
        return $result;
    }
}