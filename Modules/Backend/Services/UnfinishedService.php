<?php
/**
 * 待办事务
 * Author:CK
 * Date: 2017/11/2
 */

namespace Modules\Backend\Services;


use Illuminate\Support\Facades\DB;
use Modules\Backend\Models\Report;

class UnfinishedService
{
    /**
     * 审核通过的代办事务修改状态为已读
     */
    public function finishReport($params){
//        dd(1);
        $validator = \Validator::make($params,[
            'report_id' => 'required' ,
        ],[
            'required' => ':attribute为必填项',
        ],[
            'report_id' => '代办事务ID' ,
        ]);
        if($validator->fails()){
            return ['code' => 90002 ,'msg'=> $validator->messages()->first()];
        }
        if($params['status']!=4){
            return ['code' => 90003 , 'msg'=>'非法操作'];
        }else{
//            dd(1);
            $data['report_id'] = $params['report_id'];
            $data['status'] = 7;
            $report = Report::find($data['report_id']);
            if($report->to_admin_id==$params['admin_id']){
                $res = Report::reportChange($data);
                if($res){
                    return ['code'=>1,'msg'=>'查看成功'];
                }else{
                    return ['code'=>90002,'msg'=>'操作失败'];
                }
            }else{
                return ['code'=>10211,'msg'=>'无权操作他人的代办事务'];
            }

        }

    }
    /**
     * 未处理事务
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function unfinshedReport($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $params['risk_level'] = isset($params['risk_level']) ? $params['risk_level'] : null;

        $identity = DB::table('role_admin')
            ->join('admins','role_admin.admin_id','=','admins.admin_id')
            ->select('role_admin.role_id')
            ->where('role_admin.admin_id','=',$params['admin_id'])
            ->get()
            ->toArray();
        if(empty($identity)){
            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
        }
        $role_id = $identity[0]->role_id;
//        dd($role_id);
        if($role_id == 2){
            //民警角色所看到的代办事务（status = 2,6）
            $params['status'] = [2,6];
            $unfinished['data'] = Report::reportListByStatusPolice($params);
            $unfinished['code'] = 1;
            return $unfinished;
        }else if ($role_id == 4 ){
            //业主角色所看到的代办事务（status = 0,3,4）
            $params['status'] = [0,1,3,4];
            $unfinished['data'] = Report::reportListByStatus($params);
            $unfinished['code'] = 1;
            return $unfinished;
        }
    }
    /**
     * 已处理事务
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function overReport($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $params['risk_level'] = isset($params['risk_level']) ? $params['risk_level'] : null;

        $identity = DB::table('role_admin')
            ->join('admins','role_admin.admin_id','=','admins.admin_id')
            ->select('role_admin.role_id')
            ->where('role_admin.admin_id','=',$params['admin_id'])
            ->get()
            ->toArray();
        if(empty($identity)){
            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
        }
        $role_id = $identity[0]->role_id;
//        dd($role_id);
        if($role_id == 2){
            //民警角色所看到的已处理事务（status = 2,6）
            $params['status'] = [0,1,3,4];
            $unfinished['data'] = Report::reportListByStatusPolice($params);
            $unfinished['code'] = 1;
            return $unfinished;
        }else if ($role_id == 4 ){
            //业主角色所看到的已处理事务（status = 0,3,4）
            $params['status'] = [2,6,7];
            $unfinished['data'] = Report::reportListByStatus($params);
            $unfinished['code'] = 1;
            return $unfinished;
        }
    }
    /**
     * 全部事务
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function allReport($params)
    {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $params['risk_level'] = isset($params['risk_level']) ? $params['risk_level'] : null;
        $identity = DB::table('role_admin')
            ->join('admins','role_admin.admin_id','=','admins.admin_id')
            ->select('role_admin.role_id')
            ->where('role_admin.admin_id','=',$params['admin_id'])
            ->get()
            ->toArray();
        if(empty($identity)){
            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
        }
        $role_id = $identity[0]->role_id;
//        dd($role_id);
        if($role_id == 2){
            //民警角色所看到的全部事务（status = 2,6）
//            dd(111);
            $unfinished['data'] = Report::reportListPolice($params);
            $unfinished['code'] = 1;
            return $unfinished;
        }else if ($role_id == 4 ){
            //业主角色所看到的代办事务（status = 0,3,4）
            $unfinished['data'] = Report::reportListAll($params);
            $unfinished['code'] = 1;
            return $unfinished;
        }
    }
//    public function unfinshedReport($params)
//    {
//        if (!isset($params['status'])) {
//            return ['code' => 10220, 'msg' => '未选择事务状态'];
//        }
//        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
//        $params['page'] = isset($params['page']) ? $params['page'] : 1;
//        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
//        $params['risk_level'] = isset($params['risk_level']) ? $params['risk_level'] : null;
//        #report 状态
//        $params['sta'] = isset($params['sta']) ? $params['sta'] : null;
//        if (empty($params['risk_level'])) {
//            unset($params['risk_level']);
//        }
//        if (empty($params['keyword'])) {
//            unset($params['keyword']);
//        }
//        if (empty($params['sta'])) {
//            unset($params['sta']);
//        } else {
//            if (trim($params['sta']) == '整改发送') {
//                $params['report_status'] = 0;
//            }
//            if (trim($params['sta']) == '整改中') {
//                $params['report_status'] = 1;
//            }
//            if (trim($params['sta']) == '整改回执') {
//                $params['report_status'] = 2;
//            }
//            if (trim($params['sta']) == '再次整改发送') {
//                $params['report_status'] = 3;
//            }
//            if (trim($params['sta']) == '审核通过') {
//                $params['report_status'] = 4;
//            }
//            if (trim($params['sta']) == '已超时') {
//                $params['report_status'] = 5;
//            }
//            if (trim($params['sta']) == '再次整改回执') {
//                $params['report_status'] = 6;
//            }
//        }
//        if ($params['level'] == 1) {
//            #管理员
//            if ($params['status'] == 1) {
//                #全部事务
//                $data['list'] = Report::affairAllList($params);
//                $data['count'] = count($data['list']);
//            } elseif ($params['status'] == 3) {
//                #未处理事务
//                $data['list'] = Report::unfinshedAllList($params);
//                $data['count'] = count($data['list']);
//            } elseif ($params['status'] == 2) {
//                #已处理事务
//                $data['list'] = Report::finshedAllList($params);
//                $data['count'] = count($data['list']);
//            } else {
//                return ['code' => 10221, 'msg' => '未输入正确的status值'];
//            }
//        } elseif ($params['level'] == 2) {
//            #业主
//            if ($params['status'] == 1) {
//                #全部事务
//                $data['list'] = Report::affairAllListSelf($params);
//                $data['count'] = count($data['list']);
//            } elseif ($params['status'] == 3) {
//                #未处理事务
//                $data['list'] = Report::unfinshedAllListSelf($params);
//                $data['count'] = count($data['list']);
//            } elseif ($params['status'] == 2) {
//                #已处理事务
//                $data['list'] = Report::finshedAllListSelf($params);
//                $data['count'] = count($data['list']);
//            } else {
//                return ['code' => 10221, 'msg' => '未输入正确的status值'];
//            }
//        }elseif ($params['level'] == 3) {
//                #民警
//                if ($params['status'] == 1) {
//                    #全部事务
//                    $data['list'] = Report::affairAllListPolice($params);
//                    $data['count'] = count($data['list']);
//                } elseif ($params['status'] == 3) {
//                    #未处理事务
//                    $data['list'] = Report::unfinshedAllListPolice($params);
//                    $data['count'] = count($data['list']);
//                } elseif ($params['status'] == 2) {
//                    #已处理事务
//                    $data['list'] = Report::finshedAllListPolice($params);
//                    $data['count'] = count($data['list']);
//                } else {
//                return ['code' => 10221, 'msg' => '未输入正确的status值'];
//            }
//        } else {
//            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
//        }
//        $data['page'] = $params['page'];
//        $data['limit'] = $params['limit'];
//        return ['code' => 1, 'data' => $data];
//    }
//
//    public function unfinishReportCount($params)
//    {
//        if ($params['level'] == 1) {
//            #管理员未处理事务个数
//            $data = Report::unfinshedAllListCount($params);
//            $count = count($data);
//        } elseif ($params['level'] == 2) {
//            #业主未处理事务个数
//            $data = Report::unfinshedAllListSelfCount($params);
//            $count = count($data);
//        } elseif ($params['level'] == 3) {
//            #业主未处理事务个数
//            $data = Report::unfinshedAllListPoliceCount($params);
//            $count = count($data);
//        } else {
//            return ['code' => 10210, 'msg' => '当前用户角色无等级分配'];
//        }
//        return ['code' => 1, 'unfinshed_count' => $count];
//    }
}