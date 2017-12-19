<?php
/**
 * Created by PhpStorm.
 * User: yefan
 * Date: 2017/10/31
 * Time: 下午2:25
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $table    = 'work_schedule';

    protected $primaryKey = 'schedule_id';

    protected $fillable = array('schedule_date','schedule_time_begin','schedule_time_end');

    /**
     * 添加
     * @params string $schedule_date 当前排班日
     * @params string $schedule_time_begin 排班时间-开始
     * @params string $schedule_time_end 排班时间-结束
     * @return array
     */
    public static function scheduleAdd($params)
    {
        $res = WorkSchedule::create($params);
        return $res->schedule_id;
    }

    /**
     * 查找-批量 in
     * @params array $date 时间
     * @return array
     */
    public static function scheduleFindIn($params)
    {
        $res = WorkSchedule::whereIn('schedule_date', $params)
            ->select('schedule_id','schedule_date')->get();
        return $res;
    }

    /**
     * 查找
     * @params array $date 时间
     * @return array
     */
    public static function scheduleFind($params)
    {
        $res = WorkSchedule::where('schedule_date', $params)
            ->select('schedule_id','schedule_date')->first();
        return $res;
    }

    /**
     * 编辑排班信息 -- 废弃
     * @params string $schedule_id 排班id
     * @params string $schedule_date 某一周的某一天 年-月-日
     * @params string $schedule_time_begin 排班时间-开始
     * @params string $schedule_time_end 排班时间-结束
     * @return array
     */
    public static function scheduleEdit($params)
    {
        $data = WorkSchedule::find($params['schedule_id']);
        // $data->schedule_date = $params['schedule_date'];
        $data->schedule_time_begin = $params['schedule_time_begin'];
        $data->schedule_time_end = $params['schedule_time_end'];
        $result = $data->save();

        return $result;
    }

    /**
     * 排班信息列表
     * @params int $limit 每页显示数量
     * @params int $page  当前页数
     * @params string $now   所有\截至当前时间
     * @params string $time  某一天
     * @params string $begin 查询范围-开始时间
     * @params string $end   查询范围-结束时间
     * @return array
     */
    public static function scheduleListAll($params){
        #参数
        $offset = ($params['page'] - 1) * $params['limit'];

        $total = WorkSchedule::leftJoin('work_schedule_allot', 'work_schedule_allot.schedule_id', '=', 'work_schedule.schedule_id')
            ->Search($params)->count();

        $pages = ceil($total/$params['limit']);

        #获取数据
        $data = WorkSchedule::leftJoin('work_schedule_allot', 'work_schedule_allot.schedule_id', '=', 'work_schedule.schedule_id')
            ->Search($params)
            ->select(
                'work_schedule.schedule_id',
                'work_schedule.schedule_date',
                //'work_schedule.schedule_time_begin',
                //'work_schedule.schedule_time_end',
                'work_schedule_allot.allot_id',
                'work_schedule_allot.work_name',
                'work_schedule_allot.time_begin',
                'work_schedule_allot.time_end',
                'work_schedule_allot.remark'
            )->orderBy('work_schedule.schedule_date', 'desc')
            ->skip($offset)
            ->take($params['limit'])
            ->get()->toArray();
        foreach($data as $key=>$value){
            $data[$key]['time_longth'] = floor((strtotime($data[$key]['time_end'])-strtotime($data[$key]['time_begin']))%86400/3600);
        }
        $result['list'] = $data;
        $result['total'] = $total;
        $result['pages'] = $pages;
        return $result;
    }

    /**
     * 排班信息列表查询构造器
     * @params string $now   所有\截至当前时间
     * @params string $time  某一天
     * @params string $begin 查询范围-开始时间
     * @params string $end   查询范围-结束时间
     * @return array
     */
    public function scopeSearch($query,$params)
    {
        return $query->where(function ($query) use ($params) {
            if (isset($params['now'])){
                $query->where('work_schedule.schedule_date', '<=', $params['now']);
            } else if(isset($params['time'])){
                $query->where('work_schedule.schedule_date', '=', $params['time']);
            }else{
                $query->where('work_schedule.schedule_date', '>=', $params['begin'])
                    ->where('work_schedule.schedule_date', '<=', $params['end']);
            }
        })->where('work_schedule_allot.deleted_at','=',null);
        //->where('work_schedule_allot.admin_id','<>','')
    }

    /**
     * 每周排班信息列表
     * @params int $limit 每页显示数量  默认7 一周
     * @params int $page  当前页数
     * @params string $begin 查询范围-开始时间
     * @params string $end   查询范围-结束时间
     * @return array
     */
    public static function weekScheduleList($params){
        $number = (int)$params['page']-1;
        $string = $number < 0 ? '':"+"; //负数有'-'号、正数填充'+'号
        $begin = date('Y-m-d',strtotime($params['begin']." ".$string.($number*7)." day"));
        $end = date('Y-m-d',strtotime($params['end']." ".$string.($number*7)." day"));
        #获取数据
        $data = WorkSchedule::leftJoin('work_schedule_allot', 'work_schedule_allot.schedule_id', '=', 'work_schedule.schedule_id')
            ->where('work_schedule.schedule_date', '>=', $begin)
            ->where('work_schedule.schedule_date', '<=', $end)
            ->where('work_schedule_allot.work_name','<>','')
            ->where('work_schedule_allot.deleted_at','=',null)
            ->select(
                'work_schedule.schedule_id',
                'work_schedule.schedule_date',
                //'work_schedule.schedule_time_begin',
                //'work_schedule.schedule_time_end',
                'work_schedule_allot.allot_id',
                'work_schedule_allot.work_name',
//                'admins.admin_nick',
//                'admins.admin_sex',
                'work_schedule_allot.time_begin',
                'work_schedule_allot.time_end',
                'work_schedule_allot.remark'
            )->orderBy('work_schedule.schedule_date', 'desc')
            ->get()->toArray();

        foreach($data as $key=>$value){
            $data[$key]['time_longth'] = floor((strtotime($data[$key]['time_end'])-strtotime($data[$key]['time_begin']))%86400/3600);
        }
        $result['list'] = $data;
        $result['pages'] = $params['page'];
        return $result;
    }


}