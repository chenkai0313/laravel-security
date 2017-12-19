<?php
/**
 * 等级保护
 * Author:ck
 * Date: 2017/12/7
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\ReportGrade;

class ReportGradeService
{
    public function reportGradeAdd($params)
    {
        $data = [
            'grade_title',
            'grade_level',
            'grade_files',
        ];
        $arr = [];
        foreach ($data as $v) {
            if (array_key_exists($v, $params)) {
                $arr[$v] = $params[$v];
            }
        }
        $res = ReportGrade::gradeAdd($arr);
        if ($res) {
            return ['code' => 1, 'msg' => '添加成功', 'grade_detail' => $res];
        }
        return ['code' => 10500, 'msg' => '添加失败'];
    }

    public function reportGradeDelete($params)
    {
        if (!isset($params['grade_id']))
            return ['code' => 10501, 'msg' => 'id为必填'];
        $res = ReportGrade::gradeDelete($params);
        if ($res)
            return ['code' => 1, 'msg' => '删除成功'];
        return ['code' => 10502, 'msg' => '删除失败'];
    }

    public function reportGradeDetail($params)
    {
        if (!isset($params['grade_id']))
            return ['code' => 10501, 'msg' => 'id为必填'];
        $res = ReportGrade::gradeDetail($params);
        if ($res)
            return ['code' => 1, 'data' => $res];
        return ['code' => 10503, 'msg' => '查询失败'];
    }

    public function reportGradeEdit($params)
    {
        if (!isset($params['grade_id'])) {
            return ['code' => 10501, 'msg' => 'id为必填'];
        } else {
            $data = [
                'grade_title',
                'grade_level',
                'grade_files',
                'grade_id',
            ];
            $arr = [];
            foreach ($data as $v) {
                if (array_key_exists($v, $params)) {
                    $arr[$v] = $params[$v];
                }
            }
            $res = ReportGrade::gradeEdit($params);
            if ($res) {
                return ['code' => 1, 'msg' => '修改成功'];
            }
            return ['code' => 10504, 'msg' => '修改失败'];
        }

    }
}
