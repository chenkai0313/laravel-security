<?php
/**
 * 系统详情
 * Author: ck
 * Date: 2017/12/7
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSystem extends Model
{
    protected $table = 'report_system';

    protected $primaryKey = 'sys_id';

    protected $fillable = ['web_id', 'grade_level', 'bug_title', 'bug_files_name','bug_files_path','grade_level','grade_files_name','grade_files_path'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    //添加
    public static function systemAdd($params)
    {
        return ReportSystem::create($params);
    }

    //修改
    public static function systemEdit($params)
    {
        $edit = ReportSystem::where('sys_id', $params['sys_id'])->update($params);
        return $edit;
    }

    //删除
    public static function systemDelete($params)
    {
        return ReportSystem::where('sys_id', $params['sys_id'])->delete();
    }

    //详情
    public static function systemDetail($params)
    {
        $data = ReportSystem::leftJoin('web', 'web.web_id', '=', 'report_system.web_id')
            ->select('report_system.*', 'web.web_id', 'web.web_name', 'web.web_link')
            ->where('sys_id', $params['sys_id'])
            ->first();
        return $data;
    }
    #异常系统列表
    public static function sysListAll($params){
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        $data = ReportSystem::leftJoin('web','web.web_id','=','report_system.web_id')
            ->select('web.web_name','report_system.sys_id','report_system.created_at')
            ->whereIn('report_system.sys_id',$params['sys_id'])
            ->orderBy('report_system.created_at', 'DESC')
            ->paginate($limit);
        $res['total'] = $data->total();
        $res['page'] = ceil($data->total() / $limit);
        $res['list'] = $data -> items();
        return $res;
    }
}