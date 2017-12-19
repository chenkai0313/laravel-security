<?php
/**
 * Created by PhpStorm.
 * User: yefan
 * Date: 2017/11/1
 * Time: 上午9:38
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkScheduleAllot extends Model
{
    use SoftDeletes;

    protected $table    = 'work_schedule_allot';

    protected $primaryKey = 'allot_id';

    protected $fillable = array('work_name','schedule_id','time_begin','time_end','remark');

    /**
     * 用户班次添加
     * @params int $schedule_id 排班id
     * @params int $admin_id    用户id
     * @params string $time_begin 排班时间-开始
     * @params string $time_end   排班时间-结束
     * @return array
     */
    public static function scheduleAdd($params)
    {
        $res = WorkScheduleAllot::create($params);
        return $res->allot_id;
    }

    /**
     * 排班查找
     * @params int $schedule_id 排班id
     * @params int $admin_id    用户id
     * @return array
     */
    public static function scheduleFind($params)
    {
        $res = WorkScheduleAllot::where(function($query) use($params) {
            $query->where('schedule_id', '=',$params['schedule_id']);
            $query->where('work_name', '=',$params['work_name']);
        })->get();
        return $res;
    }

    /**
     * 排班删除
     * @params int $admin_id    用户id
     * @params int $allot_id    班次id
     * @return array
     */
    public static function scheduleDelete($params)
    {
        if(isset($params['allot_id'])){
            $result = WorkScheduleAllot::where('allot_id', $params['allot_id'])
                ->delete();
        }else{
            $result = WorkScheduleAllot::where('work_name', $params['work_name'])->delete();
        }
        return $result;
    }

    /**
     * 排班更新
     * @params int $allot_id    班次id
     * @params int $schedule_id 排班id
     * @params int $admin_id    用户id
     * @params string $time_begin 排班时间-开始
     * @params string $time_end   排班时间-结束
     * @return array
     */
    public static function scheduleEdit($params)
    {
        if(isset($params['schedule_date'])){
            unset($params['schedule_date']);
        }

        $data = WorkScheduleAllot::find($params['allot_id']);

        $data->schedule_id = $params['schedule_id'];
        if(isset($params['time_begin'])){
            $data->time_begin = $params['time_begin'];
        }
        if(isset($params['work_name'])){
            $data->work_name = $params['work_name'];
        }
        if(isset($params['time_begin'])){
            $data->time_end = $params['time_end'];
        }
        if(isset($params['remark'])){
            $data->remark = $params['remark'];
        }
        $result = $data->save();

        return $result;

//        if(isset($params['allot_id'])){
//            $data = WorkScheduleAllot::find($params['allot_id']);
//            if(empty($data)){
//                unset($params['allot_id']);
//                $result = WorkScheduleAllot::scheduleAdd($params);
//                return $result;
//            }else{
//                $result = WorkScheduleAllot::where('admin_id', $params['admin_id'])->update($params);
//                return $result;
//            }
//        }else{
//            $find = WorkScheduleAllot::scheduleFind($params);
//            if($find->isEmpty()){
//                $result = WorkScheduleAllot::scheduleAdd($params);
//                return $result;
//            }else{
//                $result = WorkScheduleAllot::where('admin_id', $params['admin_id'])->update($params);
//                return $result;
//            }
//        }
    }


    /**
     * 值班人员
     * @param $params ['admin_id'] 用户id
     * @param $params ['allot_id'] 班次id
     * @return array
     */
    public static function scheduleDetail($params)
    {
        /*$res = WorkScheduleAllot::where(function($query) use($time) {
            $query->where('time_begin', '<=',$time);
            $query->where('time_end', '>',$time);
        })->orderBy('time_begin', 'asc')
        ->first()->toArray();*/
        $data = WorkScheduleAllot::where('allot_id','=',$params['allot_id'])
            ->orderBy('time_begin', 'asc')
            ->first()->toArray();
        foreach($data as $key=>$value){
            $data[$key]['time_longth'] = floor((strtotime($data[$key]['time_end'])-strtotime($data[$key]['time_begin']))%86400/3600);
        }
        return $data;
    }

    /**
     * 当前值班人员
     * @param $params ['time'] 时间
     * @return array
     */
    public static function scheduleNow($params)
    {
        $time = $params['time'];
        $data = WorkScheduleAllot::where(function($query) use($time) {
            $query->where('time_begin', '>=',$time.' 00:00:00');
            $query->where('time_end', '<=',$time.' 23:59:59');
        })->orderBy('time_begin', 'asc')
        ->get();

        if(!empty($data)){
            $data = $data->toArray();
            foreach($data as $key=>$value){
                $data[$key]['time_longth'] = floor((strtotime($data[$key]['time_end'])-strtotime($data[$key]['time_begin']))%86400/3600);
            }
        }

        return $data;
    }

}