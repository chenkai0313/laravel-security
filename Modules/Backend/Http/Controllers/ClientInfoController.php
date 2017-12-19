<?php
/**
 * 业主情况
 * Author: CK
 * Date: 2017/11/1
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientInfoController extends Controller
{
    /**
     * 业主概况
     *$params['level']==1 查看所有  $params['level']==2 只能查看自己
     * @param Request $request
     * @return mixed
     */
    public function clientInfoList(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $params['level'] = get_r_level();
        return \ClientInfoService::clientInfoList($params);
    }

    /**
     * 业主概况编辑
     * @param Request $request
     * @return mixed
     */
    public function clientInfoEdit(Request $request)
    {
        $params = $request->input();
        return \ClientInfoService::clientInfoEdit($params);
    }

    /**
     * 业主概况删除
     * @param Request $request
     * @return mixed
     */
    public function clientInfoDelete(Request $request)
    {
        $params = $request->input();
        return \ClientInfoService::clientInfoDelete($params);
    }

    /**
     * 业主统计
     * @param Request $request
     * $params['level']==1 查看所有  $params['level']==2 只能查看自己
     * @return mixed
     */
    public function clientInfoCount(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $params['level'] = get_r_level();
        //return \ClientInfoService::clientInfoCount($params);
        return \ClientInfoService::clientInfoCountNew($params);
    }

    /**
     * 业主统计 - new
     * @param Request $request
     * $params['level']==1 查看所有  $params['level']==2 只能查看自己
     * @return mixed
     */
    public function clientInfoCountNew(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $params['level'] = get_r_level();
        return \ClientInfoService::clientInfoCountNew($params);
    }
    /**
     * 业主详情 - new
     */
    public function clientDetail(Request $request)
    {
        $params = $request->all();
        return \ClientInfoService::clientDetail($params);
    }



}