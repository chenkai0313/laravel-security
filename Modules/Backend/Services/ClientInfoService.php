<?php
/**
 * 业主情况
 * Author:CK
 * Date: 2017/10/30
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\AdminInfo;
use  Modules\Backend\Models\Report;
use Modules\Backend\Models\ReportSystem;

class ClientInfoService
{
    /**
     * 业主概况
     *$params['level']=1 查看所有  $params['level']=2 只能查看自己
     * @return mixed
     */
    public function clientInfoList($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        if ($params['level'] == 1 || $params['level'] == 3) {
            $data['list'] = AdminInfo::clientInfoListAll($params);
            $data['count'] = count($data['list']);
            $data['page'] = $params['page'];
            $data['limit'] = $params['limit'];
        } elseif ($params['level'] == 2) {
            $data['list'] = AdminInfo::clientInfoListSelf($params);
            $data['page'] = $params['page'];
            $data['limit'] = $params['limit'];
            $data['count'] = count($data['list']);
        } else {
            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
        }
        return ['code' => 1, 'data' => $data];
    }


    /**
     * 业主概况编辑
     * @return mixed
     */
    public function clientInfoEdit($params)
    {
        if (!isset($params['admin_id'])) {
            return ['code' => 90001, 'msg' => '业主信息id不能为空'];
        }
        $res = AdminInfo::adminInfoEdit($params);
        if ($res) {
            return ['code' => 1, 'msg' => '修改成功'];
        }
        return ['code' => 10212, 'msg' => '修改失败'];
    }

    /**
     * 业主概况删除
     * @return mixed
     */
    public function clientInfoDelete($params)
    {
        if (!isset($params['admin_id'])) {
            return ['code' => 90001, 'msg' => '业主信息id不能为空'];
        }
        $res = AdminInfo::adminInfoDel($params);
        if ($res) {
            return ['code' => 1, 'msg' => '删除成功'];
        }
        return ['code' => 10213, 'msg' => '删除失败'];
    }

    /**
     * 业主统计
     *$params['level']==1 查看所有  $params['level']==2 只能查看自己
     * @return mixed
     */
    public function clientInfoCount($params)
    {
        if ($params['level'] == 1 || $params['level'] == 3) {
            $data = Report::select('risk_level', 'report_id', 'created_at', 'scan_times')
                ->get();
            foreach ($data as $v) {
                $v['time'] = strtotime($v['created_at']);
            }
            #今日共扫描
            $result['today_scan_count'] = $data->where('time', '<', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>', strtotime(date('Y-m-d', time())))
                ->sum('scan_times');
            #高风险
            $result['today_scan_count_high'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 4)
                ->sum('scan_times');
            #中风险
            $result['today_scan_count_middle'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 3)
                ->sum('scan_times');
            #低风险
            $result['today_scan_count_low'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 2)
                ->sum('scan_times');
            #安全
            $result['today_scan_count_safe'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 1)
                ->sum('scan_times');
            #这周总数据
            $result['week_scan_count'] = $this->GetWeek($data);
            #这周每天数据
            $result['week_scan_count_every_day'] = $this->GetEveryDay($data);
        } elseif ($params['level'] == 2) {
            $data = Report::select('risk_level', 'report_id', 'created_at', 'scan_times', 'to_admin_id')
                ->where('to_admin_id', $params['admin_id'])
                ->get();
            foreach ($data as $v) {
                $v['time'] = strtotime($v['created_at']);
            }
            #今日共扫描
            $result['today_scan_count'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->sum('scan_times');
            #高风险
            $result['today_scan_count_high'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 4)
                ->sum('scan_times');
            #中风险
            $result['today_scan_count_middle'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 3)
                ->sum('scan_times');
            #低风险
            $result['today_scan_count_low'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 2)
                ->sum('scan_times');
            #安全
            $result['today_scan_count_safe'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 1)
                ->sum('scan_times');
            #这周总数据
            $result['week_scan_count'] = $this->GetWeek($data);
            #这周每天数据
            $result['week_scan_count_every_day'] = $this->GetEveryDay($data);
        } else {
            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
        }
        return ['code' => 1, 'data' => $result];
    }

    #这周的数据
    public function GetWeek($data)
    {
        $res = $this->GetWeekDay($data);
        $count = 0;
        foreach ($res as $v) {
            $count += $v['scan_times'];
        }
        return $count;
    }

    #计算第几周，以及这周内每天数据
    public function GetWeekDay($data)
    {
        #获取这周的数据
        $res = array();
        foreach ($data as $v) {
            if (date('W', $v['time']) == date('W', time())) {
                $res[] = $v;
            }
        }
        #获取周几date值
        foreach ($res as $v) {
            $v['date'] = date('w', $v['time']);
        }
        return $res;
    }

    #这周每天的数据
    public function GetEveryDay($data)
    {
        $res = $this->GetWeekDay($data);
        $arr = array(
            'Sun' => 0,
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Turs' => 0,
            'Fir' => 0,
            'Sat' => 0,
        );
        $Day = ['Sun', 'Mon', 'Tue', 'Wed', 'Turs', 'Fir', 'Sat'];
        for ($i = 0; $i < count($res); $i++) {
            $arr[$Day[$res[$i]['date']]] += $res[$i]['scan_times'];
        }
        return $arr;
    }


    /**
     * 业主统计 - new
     *$params['level']==1 查看所有  $params['level']==2 只能查看自己
     * @return mixed
     */
    public function clientInfoCountNew($params)
    {
        $result['today'] = date('Y-m-d', time());

        if ($params['level'] == 1 || $params['level'] == 3) {
            $data = Report::select('risk_level', 'report_id', 'created_at', 'scan_times')
                ->get();
            foreach ($data as $v) {
                $v['time'] = strtotime($v['created_at']);
            }
            #今日共扫描
            $result['today_scan_count'] = $data->where('time', '<', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>', strtotime(date('Y-m-d', time())))
                ->sum('scan_times');
            #高风险
            $result['today_scan_count_high'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 4)
                ->sum('scan_times');
            #中风险
            $result['today_scan_count_middle'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 3)
                ->sum('scan_times');
            #低风险
            $result['today_scan_count_low'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 2)
                ->sum('scan_times');
            #安全
            $result['today_scan_count_safe'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 1)
                ->sum('scan_times');
            #这周总数据
            $result['week_scan_count'] = $this->GetWeek($data);
            #这周每天数据
            $result['week_scan_count_every_day'] = $this->GetEveryDay($data);

            #月数据
            $month_data = $this->GetMonthDay($data);
            $month_count = $this->GetMonth($month_data);
            $result['month_scan_count'] = $month_count;
            $result['month_scan_count_every_day'] = $this->GetEveryMonth($month_data);

            #年数据
            $year_data = $this->GetYearDay($data);
            $year_count = $this->GetYear($year_data);
            $result['year_scan_count'] = $year_count;
            $result['year_scan_count_every_day'] = $this->GetMonthYear($year_data);

        } elseif ($params['level'] == 2) {
            $data = Report::select('risk_level', 'report_id', 'created_at', 'scan_times', 'to_admin_id')
                ->where('to_admin_id', $params['admin_id'])
                ->get();
            foreach ($data as $v) {
                $v['time'] = strtotime($v['created_at']);
            }
            #今日共扫描
            $result['today_scan_count'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->sum('scan_times');
            #高风险
            $result['today_scan_count_high'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 4)
                ->sum('scan_times');
            #中风险
            $result['today_scan_count_middle'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 3)
                ->sum('scan_times');
            #低风险
            $result['today_scan_count_low'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 2)
                ->sum('scan_times');
            #安全
            $result['today_scan_count_safe'] = $data->where('time', '<=', strtotime(date('Y-m-d', strtotime("+1 day", time()))))
                ->where('time', '>=', strtotime(date('Y-m-d', time())))
                ->where('risk_level', 1)
                ->sum('scan_times');
            #这周总数据
            $result['week_scan_count'] = $this->GetWeek($data);
            #这周每天数据
            $result['week_scan_count_every_day'] = $this->GetEveryDay($data);

            #月数据
            $month_data = $this->GetMonthDay($data);
            $month_count = $this->GetMonth($month_data);
            $result['month_scan_count'] = $month_count;
            $result['month_scan_count_every_day'] = $this->GetEveryMonth($month_data);


        } else {
            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
        }

        return ['code' => 1, 'data' => $result];
    }

    #计算月数据
    public function GetMonth($data)
    {
        $count = 0;
        foreach ($data as $v) {
            $count += $v['scan_times'];
        }
        return $count;
    }

    #计算月与当月数据
    public function GetMonthDay($data)
    {
        #获取这月的数据
        $res = array();
        foreach ($data as $v) {
            if (date('m', $v['time']) == date('m', time())) {
                $v['date'] = date('d', $v['time']);
                $res[] = $v;
            }
        }

        return $res;
    }

    #这月每天的数据
    public function GetEveryMonth($data)
    {
        $result = [];
        $month = date('m', time());
        for ($i = 1; $i < 31; $i++) {
            $result[$i] = 0;
            if ($i > 25) {
                if (date('m', strtotime("+" . $i . " day", time())) != $month) {
                    continue;
                }
            }
            foreach ($data as $v) {
                if ($v['date'] == $i) {
                    $result[$i] += $v['scan_times'];
                }
            }
        }

        return $result;
    }

    #计算年数据
    public function GetYear($data)
    {
        $count = 0;
        foreach ($data as $v) {
            $count += $v['scan_times'];
        }
        return $count;
    }

    #计算年与每月数据
    public function GetYearDay($data)
    {
        #获取这月的数据
        $res = array();
        foreach ($data as $v) {
            if (date('Y', $v['time']) == date('Y', time())) {
                $v['date'] = date('m', $v['time']);
                $res[] = $v;
            }
        }

        return $res;
    }

    #今年每月的数据
    public function GetMonthYear($data)
    {
        $result = [];
        $year = date('Y', time());
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = 0;
            foreach ($data as $v) {
                if ($v['date'] == $i) {
                    $result[$i] += $v['scan_times'];
                    unset($v);
                }
            }
        }
        return $result;
    }
    public function clientDetail($params){
        if(!isset($params['admin_id'])){
            return ['code'=>90003,'msg'=>'业主ID必填'];
        }
        $data = AdminInfo::clientDetail($params);
        if(empty($data)){
            return ['code'=>90003,'msg'=>'该业主不存在或已删除'];
        }else{
            return ['code'=>1,'data'=>$data];
        }
    }

}