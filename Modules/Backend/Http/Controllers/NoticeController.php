<?php
/**
 * Created by PhpStorm.
 * User: 张燕
 * Date: 2017/10/31
 * Time: 10:00
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NoticeController extends Controller
{
    /**
     * 公告列表
     */
    public  function noticeList(Request $request)
    {
        $params = $request->all();
        $result = \NoticeService::noticeList($params);
        return $result;
    }
    /**
     * 添加公告
     */
    public  function noticeAdd(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \NoticeService::noticeAdd($params);
        return $result;
    }
    /**
     * 编辑公告
     */
    public  function noticeEdit(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $result = \NoticeService::noticeEdit($params);
        return $result;
    }
    /**
     * 删除公告
     */
    public  function noticeDelete(Request $request)
    {
        $params = $request->all();
        $result = \NoticeService::noticeDelete($params);
        return $result;
    }
    /**
     * 公告详情
     */
    public  function noticeDetail(Request $request)
    {
        $params = $request->all();
        $result = \NoticeService::noticeDetail($params);
        return $result;
    }
    /**
     * 最新公告
     */
    public  function noticeNew()
    {
        $result = \NoticeService::noticeNew();
        return $result;
    }
}