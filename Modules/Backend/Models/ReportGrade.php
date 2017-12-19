<?php
/**
 * 等级保护
 * Author: ck
 * Date: 2017/12/7
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportGrade extends Model
{
    protected $table = 'report_grade';

    protected $dates = ['deleted_at'];

    protected $primaryKey = 'grade_id';

    protected $fillable = ['grade_title', 'grade_title', 'grade_level', 'grade_files'];

    use SoftDeletes;

    //添加
    public static function gradeAdd($params)
    {
        return ReportGrade::create($params);

    }

    //修改
    public static function gradeEdit($params)
    {
        $edit = ReportGrade::where('grade_id', $params['grade_id'])->update($params);
        return $edit;

    }

    //删除
    public static function gradeDelete($params)
    {
        return ReportGrade::where('grade_id', $params['grade_id'])->delete();
    }

    //详情
    public static function gradeDetail($params)
    {
        return ReportGrade::select('grade_id','grade_title','grade_level','grade_files')->where('grade_id', $params['grade_id'])->first();
    }
}