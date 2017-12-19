<?php
/**
 * 公文审核
 * Author: caohan
 * Date: 2017/11/13
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportExamine extends Model
{
    protected $table = 'report_examine';

    protected $primaryKey = 'examine_id';

    protected $fillable = ['report_id','police_id', 'report_name', 'examine_admin_id', 'examine_info', 'is_examine','examine_add_admin_id','examine_add_admin_nick','examine_admin_nick'];

    use SoftDeletes;

    //添加
    public static function examineAdd($params)
    {
        $add = ReportExamine::create($params);
        return $add;
    }
    //民警未审核数量
    public static function unexamineCount($params){
//        dd(111);
        $data = ReportExamine::where('is_examine','=',0)
            ->where('police_id','=',$params['admin_id'])
            ->count();
        return $data;
    }

    //编辑
    public static function examineEdit($examine_id, $params)
    {
        $edit = ReportExamine::where('examine_id', $examine_id)->update($params);
        return $edit;
    }
    public static function eEdit($params){
        $data = ReportExamine::find($params['examine_id']);
        $data->police_id = $params['police_id'];
        $res = $data->save();
        return $res;
    }

    //详情
    public static function examineDetail($params)
    {
        $report = ReportExamine::where($params)->first();
        return $report;
    }

    //所有列表
    public static function examineList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $examine = ReportExamine::Search($params)->where('police_id','=',$params['admin_id'])->orderBy('created_at', 'desc')->skip($offset)->take($params['limit'])
            ->get()->toArray();
        return $examine;
    }

    public static function examineListBySelf($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $examine = ReportExamine::Search($params)->where('examine_add_admin_id','=',$params['examine_add_admin_id'])->orderBy('created_at', 'desc')->skip($offset)->take($params['limit'])
            ->get()->toArray();
        return $examine;
    }

    #查询构造器 Like
    public function scopeSearch($query, $params)
    {
        return $query->where(function($query) use($params) {
            if (!is_null($params['keyword'])) {
                $query->where('report_id', '=', $params['keyword'] . '%')
                    ->orwhere('report_name', 'like', '%' . $params['keyword'] . '%')
                    ->orwhere('examine_id', '=', $params['keyword']);
            }
        }) ->where(function($query) use($params) {
            if (!is_null($params['is_examine']) ) {
                $query->where('is_examine', '=', $params['is_examine']);
            }
        });

    }

    public static function examineCount($params)
    {
        return ReportExamine::Search($params)->count();
    }

    public static function examineCountBySelf($params)
    {
        return ReportExamine::Search($params)->where('examine_add_admin_id','=',$params['examine_add_admin_id'])->count();
    }


}