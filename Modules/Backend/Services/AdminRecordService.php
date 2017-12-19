<?php
/**
 * Created by PhpStorm.
 * User: ck
 * Date: 2017/12/6
 * Time: 15:01
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\AdminRecord;

class AdminRecordService
{

    /**
     * 登录记录的添加
     * @return array
     */
    public function recordAdd($params)
    {
        $data = [];
        $data['record_ip'] = $params['record_ip'];
        $data['admin_id'] = $params['admin_id'];
        $data['record_status'] = $params['record_status'];
        return AdminRecord::recordAdd($data);
    }

    /**
     * 解除用户登录
     * @return array
     */
    public function unclogLogin($params)
    {
        if (!isset($params['admin_id']))
            return ['code' => 10400, 'msg' => '未传入用户ID'];
        $res = AdminRecord::unclogLogin($params);
        if ($res > 0)
            return ['code' => 1, 'msg' => '解除成功'];
        return ['code' => 104001, 'msg' => '解除失败'];
    }

    /**
     * 所有用户最后登录时间记录列表
     * @return array
     */
    public function recordList($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $data = AdminRecord::recordList($params);
        $end = $this->getNewList($data);
        #数组分页
        $start = ($params['page'] - 1) * $params['limit'];
        $totals = count($end);
        $pagedata = array();
        $pagedata = array_slice($end, $start, $params['limit']);
        $list['list'] = $pagedata;
        $list['page'] = $params['page'];
        $list['limit'] = $params['limit'];
        $list['count'] = $totals;
        return ['code' => 1, 'data' => $list];
    }

    public function getNewList($data)
    {
        $admin_id = array();
        for ($i = 0; $i < count($data); $i++)
            $admin_id[] = $data[$i]['admin_id'];
        $admin_id = array_values(array_unique($admin_id));
        $record_id = array();
        foreach ($admin_id as $s => $v)
            foreach ($data as $k)
                if ($k['admin_id'] == $v)
                    $record_id[$k['admin_id']][] = $k['record_id'];
        $result = array();
        foreach ($record_id as $v)
            $result[] = current($v);
        $end = array();
        foreach ($data as $v)
            foreach ($result as $k)
                if ($v['record_id'] == $k)
                    $end[] = $v;
        return $end;
    }

}