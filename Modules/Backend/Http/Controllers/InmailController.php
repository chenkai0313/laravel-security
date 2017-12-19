<?php
/**
 * 站内信
 * Author: CK
 * Date: 2017/10/30
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InmailController extends Controller
{
    /**
     * 站内信的新增
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailAdd(Request $request)
    {
        $params = $request->input();
        $params['user_id'] = get_admin_id();
        return \InmailService::InmailAdd($params);
    }

    /**
     * 站内信的状态改变（未读->已读）
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailEditStatus(Request $request)
    {
        $params = $request->input();
        $params['user_id'] = get_admin_id();
        return \InmailService::inmailEditStatus($params);
    }

    /**
     * 查看聊天历史记录
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailHistory(Request $request)
    {
        $params = $request->input();
        return \InmailService::inmailHistory($params);
    }

    /**
     * 模糊查找用户
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailSearchUser(Request $request)
    {
        $params = $request->input();
        return \InmailService::inmailSearchUser($params);
    }

    /**
     * 删除站内信（支持批量删除）
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailDelete(Request $request)
    {
        $params = $request->input();
        return \InmailService::inmailDelete($params);
    }

    /**
     * 站内信列表
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailList(Request $request)
    {
        $params = $request->input();
        $params['user_id'] = get_admin_id();
        return \InmailService::inmailList($params);
    }

    /**
     * 当前存在未读信息个数
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailUnreadCount(Request $request)
    {
        $params = $request->input();
        $params['user_id'] = get_admin_id();
        return \InmailService::inmailUnreadCount($params);
    }
    /**
     * 站内信详情
     *
     * @param Request $request
     * @return mixed
     */
    public function inmailDetail(Request $request)
    {
        $params = $request->input();
        return \InmailService::inmailDetail($params);
    }
}