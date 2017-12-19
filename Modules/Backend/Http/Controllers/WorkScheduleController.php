<?php
/**
 * Created by PhpStorm.
 * User: yefan
 * Date: 2017/10/31
 * Time: 下午2:12
 */

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WorkScheduleController extends Controller
{
    /**
     *  创建本周初始排班
     */
    public function weekScheduleAdd(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::weekScheduleAdd($params);
        return $result;
    }

    /**
     *  编辑某一天排班时间
     */
    public function weekScheduleEdit(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::weekScheduleEdit($params);
        return $result;
    }

    /**
     *  用户添加班次-批量
     */
    public function scheduleAdd(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::scheduleAdd($params);
        return $result;
    }

    /**
     *  用户添加班次
     */
    public function scheduleAddSingle(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::scheduleAddSingle($params);
        return $result;
    }

    /**
     *  用户班次修改
     */
    public function scheduleEdit(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::scheduleEdit($params);
        return $result;
    }

    /**
     *  总排班列表
     */
    public function scheduleList(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::ScheduleListAll($params);
        return $result;
    }

    /**
     *  周排班列表
     */
    public function scheduleWeekList(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::WeekScheduleList($params);
        return $result;
    }

    /**
     *  值班者信息
     */
    public function scheduleDetail(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::ScheduleDetail($params);
        return $result;
    }

    /**
     *  当前时间值班者信息
     */
    public function scheduleNow(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::ScheduleNow($params);
        return $result;
    }

    /**
     *  班次删除
     */
    public function scheduleDelete(Request $request) {
        $params = $request->input();
        $result = \WorkScheduleService::ScheduleDelete($params);
        return $result;
    }



}