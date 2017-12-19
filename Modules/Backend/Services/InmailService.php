<?php
/**
 * 站内信
 * Author:CK
 * Date: 2017/10/30
 */
//                   _ooOoo_
//                  o8888888o
//                  88" . "88
//                  (| -_- |)
//                  O\  =  /O
//               ____/`---'\____
//             .'  \\|     |//  `.
//            /  \\|||  :  |||//  \
//           /  _||||| -:- |||||-  \
//           |   | \\\  -  /// |   |
//           | \_|  ''\---/''  |   |
//           \  .-\__  `-`  ___/-. /
//         ___`. .'  /--.--\  `. . __
//      ."" '<  `.___\_<|>_/___.'  >'"".
//     | | :  `- \`.;`\ _ /`;.`/ - ` : | |
//     \  \ `-.   \_ __\ /__ _/   .-` /  /
//======`-.____`-.___\_____/___.-`____.-'======
//                   `=---='
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//         佛祖保佑       永无BUG
//  本模块已经经过开光处理，绝无可能再产生bug

namespace Modules\Backend\Services;

use Modules\Backend\Models\Admin;
use Modules\Backend\Models\Inmail;

class InmailService
{
    /**
     * 添加站内信
     * @param $params ['inmail_content']  内容
     * @param $params ['sender_id']  发件人ID
     * @param $params ['receiver_id']  收件人ID
     * @param $params ['status']  状态（0 未读 1已读）
     * @param $params ['pid']  所属上一条ID
     * @return array
     */
    public function InmailAdd($params)
    {
        $params['sender_id'] = $params['user_id'];
        $params['status'] = isset($params['status']) ? $params['status'] : 0;
        $validator = \Validator::make(
            $params,
            \Config::get('validator.system.inmail.inmail-add'),
            \Config::get('validator.system.inmail.inmail-key'),
            \Config::get('validator.system.inmail.inmail-val')
        );
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        $SenderExist = Admin::where('admin_id', '=', $params['sender_id'])->first();
        if (!isset($SenderExist)) {
            return ['code' => 10202, 'msg' => '发件人不存在'];
        }
        $ReceiverExist = Admin::where('admin_id', '=', $params['receiver_id'])->first();
        if (!isset($ReceiverExist)) {
            return ['code' => 10203, 'msg' => '收件人不存在'];
        }
        $add = Inmail::InmailAdd($params);
        if ($add) {
            $result['code'] = 1;
            $result['msg'] = "发送成功";
        }
        return $result;
    }

    /**
     * 站内信的状态改变（未读->已读 支持批量修改）
     * @param $params ['status']  状态（0 未读 1已读）
     * @return array
     */
    public function inmailEditStatus($params)
    {
        if (!isset($params['inmail_id'])) {
            return ['code' => 10204, 'msg' => '站内信ID不存在'];
        }
        $res = Inmail::inmailEditStatus($params);
        if ($res) {
            $result['code'] = 1;
            $result['msg'] = "修改成功";
        }
        return $result;
    }

    /**
     * 查看聊天历史记录
     *
     * @return array
     */
    public function inmailHistory($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        if (!isset($params['sender_id'])) {
            return ['code' => 10202, 'msg' => '发件人ID不存在'];
        }
        if (!isset($params['receiver_id'])) {
            return ['code' => 10203, 'msg' => '收件人ID不存在'];
        }
        $data = Inmail::inmailHistory($params);
        if ($data) {
            $result['count'] = Inmail::inmailHistoryCount($params);
            $result['code'] = 1;
            $result['history'] = $data;
        }
        return $result;
    }

    /**
     * 模糊查找用户
     *
     * @return array
     */
    public function inmailSearchUser($params)
    {
        $params['company_name'] = isset($params['company_name']) ? $params['company_name'] : null;
        $data = Inmail::inmailSearchUser($params);
        if ($data) {
            $result['code'] = 1;
            $result['list'] = $data;
            $result['count'] = count($data);
        }
        return $result;
    }

    /**
     * 删除站内信（支持批量删除）
     *
     * @return array
     */
    public function inmailDelete($params)
    {
        if (!isset($params['inmail_id'])) {
            return ['code' => 10204, 'msg' => '站内信ID不存在'];
        }
        $inmail_id = explode(',', $params['inmail_id']);
        $res = Inmail::inmailDelete($inmail_id);
        if ($res) {
            $result['code'] = 1;
            $result['msg'] = "删除成功";
        }
        return $result;
    }

    /**
     * 站内信列表
     * @return array
     */
    public function inmailList($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $params['status'] = isset($params['status']) ? $params['status'] : null;
        $params['mailsign'] = isset($params['mailsign']) ? $params['mailsign'] : 1;

        if(empty($params['status'])){
            unset($params['status']);
        }else{
            if(trim($params['status'])=='已读'){
                $params['status']=1;
            }
            if(trim($params['status'])=='未读'){
                $params['status']=0;
            }
        }
        if(empty($params['keyword'])){
            unset($params['keyword']);
        }
        $data['list'] = Inmail::inmailList($params);
        $data['count'] = count($data['list']);
        // $data['count'] = Inmail::inmailListCount($params);
        $data['page'] = $params['page'];
        $count = $data['count'] / $params['limit'];
        if ($count < 1) {
            $data['count_page'] = 1;
        } else {
            $data['count_page'] = ceil($count);
        }
        return ['code' => 1, 'data' => $data];
    }

    /**
     * 当前存在未读信息个数
     * @return array
     */
    public function inmailUnreadCount($params)
    {
        $data = Inmail::inmailUnreadCount($params);
        return ['code' => 1, 'unreadcount' => $data];
    }

    /**
     * 站内信详情
     * @return array
     */
    public function inmailDetail($params)
    {
        if (!isset($params['inmail_id'])) {
            return ['code' => 10204, 'msg' => '站内信ID不存在'];
        }
        $data['detail'] = Inmail::inmailDetail($params);
        return ['code' => 1, 'data' => $data];
    }
}
