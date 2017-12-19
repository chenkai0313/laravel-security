<?php
/**
 * 报告
 * Author: caohan
 * Date: 2017/10/30
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Backend\Facades\ReportGradeFacade;
use Modules\Backend\Services\ReportService;

class ReportController extends Controller
{
    /**
     * 民警未审核公文数量
     */
    public function unexamineCount(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::unexamineCount($params);
    }

    /**
     * 新增报告
     */
    public function reportAdd(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $params['examine_add_admin_nick'] = get_jwt('admin_nick');
        return \ReportService::reportAdd($params);
    }

    public function fileUpLoad(Request $request)
    {
        $files = is_null($request->file('files')) ? '' : $request->file('files');
        $upload = uploadFiles($files);//上传文件
        $data['file_url'] = config('system.files_domain').$upload['file_path'];
        $data['file_name'] = $upload['file_name'];
        $data['file_path'] = $upload['file_path'];
        return ['code' => 1, 'data' => $data];
    }

    // 审核时文件上传（主要是因为运维不能看公文列表，但是上传在公文列表中，现在 添加一个上传到公文审核中）
    public function examineFileUpLoad(Request $request)
    {
        $files = is_null($request->file('files')) ? '' : $request->file('files');
        $upload = uploadFiles($files);//上传文件
        $data['file_name'] = $upload['file_name'];
        $data['file_path'] = $upload['file_path'];
        return ['code' => 1, 'data' => $data];
    }

    /**
     * 某一报告详情+回执
     */
    public function reportDetail(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::reportDetail($params);
    }

    /**
     * 审核详情-运维接口
     */
    public function reportDetailYW(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::reportDetail($params);
    }

    /**
     * 所有用户的报告
     */
    public function reportList(Request $request)
    {
        //ROle role等级 1看所有 2看自己
        $params = $request->input();
        $params['r_level'] = get_r_level();
        $params['admin_id'] = get_admin_id();
        return \ReportService::reportList($params);
    }

    /**
     * 编辑报告
     */
    public function reportEdit(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::reportEdit($params);
    }


    public function reportSuccess(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::reportSuccess($params);
    }

    public function downloadRecord(Request $request)
    {
        return ['code' => 1, 'msg' => '记录成功'];
    }

    public function reportTimeRefresh(Request $request)
    {
        return \ReportService::reportTimeRefresh();
    }

    /**
     * 代办事务列表
     */
    public function unfinishedReport(Request $request)
    {
        $params = $request->all();
        $params['admin_id'] = get_admin_id();
        $params['level'] = get_r_level();
        $result = \ReportService::unfinshedreport($params);
        return $result;
    }

    /*********************************** 回执模块  **************************************/
    //添加回执
    public function receiptAdd(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::receiptAdd($params);
    }

    //编辑回执
    public function receiptEdit(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $params['r_level'] = get_r_level();
        return \ReportService::receiptEdit($params);
    }

    //编辑回执为已读
    public function receiptRead(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        return \ReportService::receiptRead($params);
    }

    public function receiptList(Request $request)
    {
        $params = $request->input();
        return \ReportService::receiptList($params);
    }

    public function reportListByExamine(Request $request)
    {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $params['r_level'] = get_r_level();
        return \ReportService::reportListByExamine($params);
    }

    public function reportExamineEdit(Request $request)
    {
        $params = $request->input();
        $params['examine_admin_id'] = get_admin_id();
        $params['examine_admin_nick'] = get_jwt('admin_nick');
        return \ReportService::reportExamineEdit($params);
    }

    public function reportEditByExamine(Request $request)
    {
        $params = $request->input();
        return \ReportService::reportEditByExamine($params);
    }

    //等级保护附件的添加
    public function reportGradeAdd(Request $request)
    {
        $params = $request->input();
        return \ReportGradeService::reportGradeAdd($params);
    }

    //等级保护附件的删除
    public function reportGradeDelete(Request $request)
    {
        $params = $request->input();
        return \ReportGradeService::reportGradeDelete($params);
    }

    //等级保护附件的详情
    public function reportGradeDetail(Request $request)
    {
        $params = $request->input();
        return \ReportGradeService::reportGradeDetail($params);
    }

    //等级保护附件的修改
    public function reportGradeEdit(Request $request)
    {
        $params = $request->input();
        return \ReportGradeService::reportGradeEdit($params);
    }

    //系统详情的添加
    public function reportSystemAdd(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemAdd($params);
    }

    //系统详情的修改
    public function reportSystemEdit(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemEdit($params);
    }

    //系统详情的删除
    public function reportSystemDelete(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemDelete($params);
    }

    //系统详情的详情
    public function reportSystemDetail(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemDetail($params);
    }
    //系统详情的详情(业主情况)
    public function reportSystemDetailByOwner(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemDetail($params);
    }

    //查询异常系统列表
    public function sysList(Request $request)
    {
        $params = $request->all();
        return \ReportService::sysList($params);
    }

    //系统列表
    public function reportSystemWebList(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemWebList($params);
    }


    //系统列表
    public function reportWebList(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemWebList($params);
    }


    //系统详情的详情
    public function reportOwnerDetail(Request $request)
    {
        $params = $request->input();
        return \ReportSystemService::reportSystemDetail($params);
    }
}
