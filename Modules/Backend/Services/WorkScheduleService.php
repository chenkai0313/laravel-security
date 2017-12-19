<?php
/**
 * Created by PhpStorm.
 * User: yefan
 * Date: 2017/10/31
 * Time: 下午2:07
 */

namespace Modules\Backend\Services;

use Modules\Backend\Models\WorkSchedule;
use Modules\Backend\Models\WorkScheduleAllot;
use Modules\Backend\Models\Admin;
use Modules\Backend\Models\AdminInfo;

class WorkScheduleService
{
    /**
     * 初始排班创建、一周
     * @param $params ['schedule_date'] 某一周的某一天 年-月-日
     * @return array
     */
    public function weekScheduleAdd($params){
        $validator = \Validator::make(
            $params,
            \Config::get('validator.schedule.work_schedule.week-add'),
            \Config::get('validator.schedule.work_schedule.week-key'),
            \Config::get('validator.schedule.work_schedule.week-val')
        );
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }
        // 过滤时间参数
        if(!isDateTime($params['schedule_date'])){
            return ['code' => 90002, 'msg' => '非时间参数'];
        }
        $params['schedule_date'] = date("Y-m-d",strtotime($params['schedule_date']));
        // 整理一周排班数据
        $week = isWeek($params['schedule_date']);
        if($week['data'] === "0"){ // 礼拜天 值为0
            $week['data'] = "7";
        }
        $weekParams = [
            $week['data'] => $params['schedule_date']
        ];
        $data = [];
        for ($i = 1; $i <= 7; $i++){
            if($week['data'] != $i){
                $string = $i > $week['data'] ? "+":"-";
                $string .= abs($i-$week['data'])." day";
                $string = $params['schedule_date'].' '.$string;
                $data[] = $weekParams[$i] = date('Y-m-d',strtotime($string));
            }else{
                $data[] = $params['schedule_date'];
            }
        }
        $schedule_array = [];
        $number = 7;
        $res = WorkSchedule::scheduleFindIn($data);
        foreach ($res as $key=>$value){
            foreach ($data as $k=>$v){
               if($res[$key]['schedule_date'] == $data[$k]){
                   $schedule_array[] =  [
                       'schedule_date' => $res[$key]['schedule_date'],
                       'schedule_id' => $res[$key]['schedule_id'],
                   ];
                   unset($data[$k]);
                   $number--;
               }
            }
        }

        foreach ($data as $key=>$value){
            $week_data = [
                'schedule_date' => $value,
                'schedule_time_begin' => $value." 8:00:00",
                'schedule_time_end' => $value." 23:59:59",
            ];

            $schedule_id = WorkSchedule::scheduleAdd($week_data);
            if($schedule_id){
                $schedule_array[] =  [
                    'schedule_date' => $value,
                    'schedule_id' => $schedule_id,
                ];
            }
        }

        if($number == 0){
            return ['code'=>10310, 'msg'=>"周排班初始化数据已经完成",'data'=>$schedule_array];
        }else{
            return ['code'=>1, 'msg'=>'插入成功', 'data'=>$schedule_array];
        }
    }

    /**
     * 编辑排班信息 -- 废弃
     * @params string $schedule_id 排班id
     * @params string $schedule_date 某一周的某一天 年-月-日
     * @params string $schedule_time_begin 排班时间-开始
     * @params string $schedule_time_end 排班时间-结束
     * @return array
     */
    public function weekScheduleEdit($params){
        $res = WorkSchedule::ScheduleEdit($params);
        if($res){
            return ['code' => 1, 'msg' => '修改成功'];
        }else{
            return ['code' => 10311, 'msg' => '周排班数据修改失败'];
        }
    }

    /**
     * 用户班次添加-批量一周
     * @params json list    排班信息json串
     * @params string schedule_begin    排班开始时间
     *
     * @params int $admin_id    用户id json list
     * @params string $time_begin  排班时间-开始 json list
     * @params string $time_end    排班时间-结束 json list
     *
     * @params int $schedule_id 排班id  增加后返回值
     * @return array
     */
    public function scheduleAdd($params){
        if( !isset($params['list']) || !isset($params['schedule_begin'])){
            return ['code'=>90002, 'msg'=>"请添加班次与排班时间数据"];
        }
        // 增加排班
        $schedule = \WorkScheduleService::weekScheduleAdd(['schedule_date'=>$params['schedule_begin']]);
//        dd($schedule);
        $schedule_list = $schedule['data'];
        $list = $params['list'];
        //$list = json_decode($params['list'],true);
        // 分配排班
        $number = 0;
        $error_list = [];
        foreach ($list as $key=>$value){
            if( strstr($list[$key]['time_end'],'24:00:00') == '24:00:00' ){
                $ymd = strstr($list[$key]['time_end'], '24:00:00', TRUE);
                $list[$key]['time_end'] = $ymd.'23:59:59';
            }
            foreach($schedule_list as $k=>$v){
                if(strtotime($list[$key]['schedule_date']) == strtotime($schedule_list[$k]['schedule_date'])){
                    $data = [
                        'work_name' => $list[$key]['work_name'],
                        'schedule_id' => $schedule_list[$k]['schedule_id'],
                        'time_begin' => $list[$key]['time_begin'],
                        'time_end' => $list[$key]['time_end'],
                        'remark' => $list[$key]['remark'],
                    ];
                    $find = WorkScheduleAllot::scheduleFind($data);
                    if( $find->isEmpty() ){
                        WorkScheduleAllot::scheduleAdd($data);
                        $number++;
                        break;
                    }else{
                        $error_list[] = $list[$key];
                    }
                }
            }
        }

        if($number === 0){
            return [
                'code' => 10310,
                'msg' => '存在排班失败数据',
                'data'=>[
                    'list' => $error_list,
                    'schedule_begin' => $params['schedule_begin']
                ]
            ];
        }else{
            return ['code'=>1,'msg'=>'排班成功'];
        }

    }

    /**
     * 用户班次添加
     * @params json list    排班信息json串
     * @params string schedule_begin    排班开始时间
     *
     * @params int $admin_id    用户id json list
     * @params string $time_begin  排班时间-开始 json list
     * @params string $time_end    排班时间-结束 json list
     *
     * @params int $schedule_id 排班id  增加后返回值
     * @return array
     */
    public function scheduleAddSingle($params){
        if( !isset($params['list']) || !isset($params['schedule_begin'])){
            return ['code'=>90002, 'msg'=>"请添加班次与排班时间数据"];
        }

        // 排班查询
        $schedule = WorkSchedule::scheduleFind(['schedule_date'=>$params['schedule_begin']]);
        if(empty($schedule)){
            return ['code'=>10315, 'msg'=>"排班信息不存在"];
        }
        $schedule_id = $schedule['schedule_id'];
        $list = $params['list'];
        //$list = json_decode($params['list'],true);

        // 分配排班
        $number = 0;
        $schedule_list = [];
        foreach ($list as $key=>$value){
            if( strstr($list[$key]['time_end'],'24:00:00') == '24:00:00' ){
                $ymd = strstr($list[$key]['time_end'], '24:00:00', TRUE);
                $list[$key]['time_end'] = $ymd.'23:59:59';
            }
            $data = [
                'work_name' => $list[$key]['work_name'],
                'schedule_id' => $schedule_id,
                'time_begin' => $list[$key]['time_begin'],
                'time_end' => $list[$key]['time_end'],
                'remark' => $list[$key]['remark'],
            ];

            $find = WorkScheduleAllot::scheduleFind($data);
            if( $find->isEmpty() ){
                WorkScheduleAllot::scheduleAdd($data);
                $number++;
            }else{
                $schedule_list[] = $data;
            }
        }
        if($number > 0){
            return ['code'=>1,'msg'=>'排班成功'];
        }else{
            return [
                'code' => 10310,
                'msg' => '排班失败',
                'data'=>[
                    'list' => $schedule_list,
                    'schedule_begin' => $params['schedule_begin']
                ]
            ];
        }

    }

    /**
     * 用户班次修改
     * @params int $allot_id    班次id
     * @params int schedule_date  班次时间
     * @params int $schedule_id 排班id - 查询后拿到
     * @params int $admin_id    用户id
     * @params string $time_begin 排班时间-开始
     * @params string $time_end   排班时间-结束
     * @return array
     */
    public function scheduleEdit($params){
        unset($params['s']);
        if( !isset($params['schedule_date']) || !isset($params['work_name']) ||!isset($params['allot_id']) ){
            return ['code' => 90001, 'msg' => '必须存在班次时间\用户id\班次id'];
        }

        $find = WorkSchedule::scheduleFind($params['schedule_date']);

        if(empty($find)){
            return ['code' => 10315, 'msg' => '班次信息不存在，获取失败'];
        }
        $params['schedule_id'] = $find['schedule_id'];
        $res = WorkScheduleAllot::scheduleEdit($params);

        if($res){
            return ['code' => 1, 'msg' => '修改成功'];
        }else{
            return ['code' => 10314, 'msg' => '班次信息修改失败'];
        }
    }

    /**
     * 总排班列表
     * @params int $limit 每页显示数量
     * @params int $page  当前页数
     * @params int $year  年
     * @params int $month 月
     * @params int $day   日
     * @return array
     */
    public function ScheduleListAll($params){
        $data = [];
        if( isset($params['day']) ){
            $time = $params['year'].'-'.$params['month'].'-'.$params['day'];
            $data['time'] = $time;
        }else if( isset($params['month']) ){
            $time = $params['year'].'-'.$params['month'].'-01';
            $begin = date('Y-m-d',strtotime($time.' -1 day'));
            $data['begin'] = $begin;
            $end = date('Y-m-d',strtotime($time.' +1 month'));
            $end = date('Y-m-d',strtotime($end.' -1 day'));
            $data['end'] = $end;
        }else if( isset($params['year']) ){
            $time = $params['year'].'-01-01';
            $begin = date('Y-m-d',strtotime($time.' -1 day'));
            $data['begin'] = $begin;
            $end = date('Y-m-d',strtotime($time.' +1 year'));
            $end = date('Y-m-d',strtotime($end.' -1 day'));
            $data['end'] = $end;
        }else{
            $data['now'] = date('Y-m-d');
        }

        $data['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        $data['page'] = isset($params['page']) ? $params['page'] : 1;

        $res = WorkSchedule::scheduleListAll($data);

        if($res){
            return ['code' => 1, 'data' => $res];
        }else{
            return ['code' => 10315, 'msg' => '排班、班次信息不存在，获取失败'];
        }
    }

    /**
     * 周排班列表
     * @params int $limit 每页显示数量  默认7 一周
     * @params int $page  当前页数
     * @params string schedule_date  其中一周的某一天
     * @return array
     */
    public function WeekScheduleList($params){
        if( !isset($params['schedule_date']) || empty($params['schedule_date']) ){
            $params['schedule_date'] = date('Y-m-d H:i:s');
        }
        $week = isWeek($params['schedule_date']);
        if($week['data'] === "0"){ // 礼拜天 值为0
            $week['data'] = "7";
        }

        $string1 = 7-(int)$week['data'];
        $string1 = $params['schedule_date']." +".$string1." day";
        $end = date('Y-m-d',strtotime($string1));
        $string2 = (int)$week['data']-1;
        $string2 = $params['schedule_date']." -".$string2." day";
        $begin = date('Y-m-d',strtotime($string2));

        $data = [
            'begin' => $begin,
            'end' => $end,
        ];

        $data['limit'] = isset($params['limit']) ? $params['limit'] : 7;
        $data['page'] = isset($params['page']) ? $params['page'] : 1;

        $res = WorkSchedule::weekScheduleList($data);

        if($res){
            return ['code' => 1, 'data' => $res];
        }else{
            return ['code' => 10315, 'msg' => '排班、班次信息不存在，获取失败'];
        }
    }

    /**
     * 值班者信息
     * @param $params ['admin_id'] 用户id
     * @param $params ['allot_id'] 班次id
     * @return array
     */
    public function ScheduleDetail($params){
        if( !isset($params['allot_id']) && !isset($params['work_name']) ){
            return ['code' => 90001, 'msg' => '必须存在用户名或班次id'];
        }

        $res = WorkScheduleAllot::scheduleDetail($params);
        if($res){
//            $admin_id = $params['admin_id'];
//            $info1 = Admin::adminDetail($admin_id)->toArray();
//            $info2 = AdminInfo::adminInfo($admin_id)->toArray();
//
//            foreach ($info2 as $k => $v){
//                if($k == "updated_at" || $k == "created_at"){
//                }else{
//                    $info1[$k] = $v;
//                }
//            }
//
//            foreach ($info1 as $k => $v){
//                $res[$k] = $v;
//            }

            return ['code' => 1, 'data' => $res];
        }else{
            return ['code' => 10315, 'msg' => '排班、班次信息不存在，获取失败'];
        }
    }

    /**
     * 当前时间值班者信息
     * @param $params ['time'] 时间
     * @return array
     */
    public function ScheduleNow($params){

        $params['time'] = date('Y-m-d');
        $res = WorkScheduleAllot::scheduleNow($params);

        if($res){
//            foreach ($res as $key=>$value){
//                $admin_id = $res[$key]['admin_id'];
//                $info1 = Admin::adminDetail($admin_id)->toArray();
//                $info2 = AdminInfo::adminInfo($admin_id)->toArray();
//
//                foreach ($info2 as $k => $v){
//                    if($k == "updated_at" || $k == "created_at"){
//                    }else{
//                        $info1[$k] = $v;
//                    }
//                }
//
//                foreach ($info1 as $k => $v){
//                    $res[$key][$k] = $v;
//                }
//            }

            return ['code' => 1, 'data' => $res];
        }else{
            return ['code' => 10315, 'msg' => '排班、班次信息不存在，获取失败'];
        }
    }

    //班次删除
    public function ScheduleDelete($params){
        $res = WorkScheduleAllot::scheduleDelete($params);
        if($res){
            return ['code' => 1, 'msg' => '删除成功'];
        }else{
            return ['code' => 10316, 'msg' => '班次删除失败'];
        }
    }


}