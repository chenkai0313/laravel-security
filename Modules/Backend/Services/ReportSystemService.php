<?php
/**
 * 系统详情
 * Author:ck
 * Date: 2017/12/7
 */

namespace Modules\Backend\Services;


use Modules\Backend\Models\ReportSystem;
use Modules\Backend\Models\Web;

class ReportSystemService
{
    public function reportSystemAdd($params)
    {
        $data = [
            'web_id',
            'bug_title',
            'bug_files_name',
            'bug_files_path',
            'grade_files_name',
            'grade_files_path',
            'grade_level',
        ];
        $arr = [];
        foreach ($data as $v) {
            if (array_key_exists($v, $params)) {
                $arr[$v] = $params[$v];
            }
        }
        $res = ReportSystem::systemAdd($arr);
        if ($res)
            return ['code' => 1, 'msg' => '添加成功', 'sys_id' => $res['sys_id']];
        return ['code' => 10600, 'msg' => '添加失败'];
    }

    public function reportSystemEdit($params)
    {

        if (!isset($params['sys_id'])) {
            return ['code' => 10601, 'msg' => 'id为必填项'];
        } else {
            $data = [
                'sys_id',
                'web_id',
                'bug_title',
                'bug_files_name',
                'bug_files_path',
                'grade_files_name',
                'grade_files_path',
                'grade_level',
            ];
            $arr = [];
            foreach ($data as $v) {
                if (array_key_exists($v, $params)) {
                    $arr[$v] = $params[$v];
                }
            }
            $res = ReportSystem::systemEdit($arr);
            if ($res)
                return ['code' => 1, 'msg' => '修改成功', 'sys_id' => $params['sys_id']];
            return ['code' => 10602, 'msg' => '修改失败'];
        }

    }

    public function reportSystemDelete($params)
    {
        if (!isset($params['sys_id']))
            return ['code' => 10601, 'msg' => 'id为必填'];
        $res = ReportSystem::systemDelete($params);
        if ($res)
            return ['code' => 1, 'msg' => '删除成功'];
        return ['code' => 10603, 'msg' => '删除失败'];
    }

    public function reportSystemDetail($params)
    {
        if (!isset($params['sys_id']))
            return ['code' => 10601, 'msg' => 'id为必填'];
        $res = ReportSystem::systemDetail($params);
        $res['bug_title_list'] = explode('|', $res['bug_title']);
        $res['grade_level_list'] = explode('|', $res['grade_level']);
        $bug_file_name = explode('|', $res['bug_files_name']);
        $bug_file_path = explode('|', $res['bug_files_path']);
        $files_info1 = array();
        if ($res['bug_files_path']) {
            foreach ($bug_file_name as $k => $v) {
                foreach ($bug_file_path as $m => $n) {
                    try {
                        $files_info1[$k]['bug_file_name'] = $v;
                        $files_info1[$m]['bug_file_path'] = config('system.files_domain') . $n;
                    } catch (\Exception $e) {
                        return ['code' => '500', 'msg' => '文件查询出错'];
                    }
                }
            }
        }
        $res['bug_files_list'] = $files_info1;
        $grade_file_name = explode('|', $res['grade_files_name']);
        $grade_file_path = explode('|', $res['grade_files_path']);
        $files_info2 = array();
        if ($res['grade_files_path']) {
            foreach ($grade_file_name as $k => $v) {
                foreach ($grade_file_path as $m => $n) {
                    try {
                        $files_info2[$k]['grade_file_name'] = $v;
                        $files_info2[$m]['grade_file_path'] = config('system.files_domain') . $n;
                    } catch (\Exception $e) {
                        return ['code' => '500', 'msg' => '文件查询出错'];
                    }
                }
            }
        }
        $res['grade_files_list'] = $files_info2;
        if ($res)
            return ['code' => 1, 'data' => $res];
        return ['code' => 10604, 'msg' => '查询失败'];
    }

    public function reportSystemWebList($params)
    {
        if (!isset($params['admin_id']))
            return ['code' => 10601, 'msg' => 'id为必填'];
        $data = Web::select('web_id', 'web_name', 'web_link')->where('admin_id', $params['admin_id'])->get();
        return ['code' => 1, 'data' => $data];
    }

}
