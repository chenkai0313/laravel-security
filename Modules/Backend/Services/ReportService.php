<?php
/**
 * 报告service
 * Author:caohan
 * Date: 2017/10/30
 */

namespace Modules\Backend\Services;

use Modules\Backend\Models\Admin;
use Modules\Backend\Models\AdminInfo;
use Modules\Backend\Models\Receipt;
use Modules\Backend\Models\Report;
use Modules\Backend\Models\ReportExamine;
use Modules\Backend\Models\ReportSystem;
use Modules\Backend\Models\Web;

class ReportService
{
    //TODO*******************************************************   报告模块  *********************************************/
    /**
     * 报告添加
     * @param $params
     * @return mixed
     */
    public function unexamineCount($params){
        $res = ReportExamine::unexamineCount($params);
        if($res){
            $data['code'] = 1;
            $data['msg'] = '查询成功';
            $data['count'] = $res;
        }
        else if(empty($res)){
            $data['code'] = 1;
            $data['msg'] = '数据为空';
            $data['count'] =0;
        }else{
            $data['code'] = 90002;
            $data['msg'] = '查询失败';
        }
        return $data;
    }
    /**
     * 报告添加
     * @param $params
     * @return mixed
     */
    public function reportAdd($params) {
        $validator = \Validator::make(
            $params,
            \Config::get('validator.system.report.report-add'),
            \Config::get('validator.system.report.report-key'),
            \Config::get('validator.system.report.report-val')
        );
        if (!$validator->passes()) {
            return ['code' => 90002, 'msg' => $validator->messages()->first()];
        }

        unset($params['s']);
        $admin = AdminInfo::adminInfo($params['to_admin_id']);
        $params['company_name'] = $admin['company_name'];
        $params['status'] = config('report-status.status.send_rectify');
        $add = Report::reportAdd($params);
        if ($add) {
            //TODO 在审核表里添加对应的公文
            $examine_condition = ['report_id'=>$add['report_id'],'police_id'=>$params['police_id'],'report_name'=>$add['report_name'],'examine_add_admin_id'=>$params['admin_id'],'examine_add_admin_nick'=>$params['examine_add_admin_nick']];
            $add_examine = ReportExamine::examineAdd($examine_condition);
            return ['code' => 1, 'msg' => '公文添加成功'];
        }
        else
            return ['code' => 500, 'msg' => '公文添加失败'];
    }

    /**
     * 编辑报告
     * @param $params
     * @return array
     */
    public function reportEdit($params) {
        if (!isset($params['report_id']))
            return ['code'=>500,'msg'=>'report_id必填'];

        unset($params['s']);
        $report_id =$params['report_id'];
        unset($params['report_id']);
        $edit = Report::reportEdit($report_id,$params);
        if ($edit){
            $res = ReportExamine::eEdit($params);
            if ($res){
                return ['code' => 1, 'msg' => '公文编辑成功'];
            } else{
                return ['code' => 500, 'msg' => '公文审核编辑失败'];
            }
        } else{
            return ['code' => 500, 'msg' => '公文编辑失败'];
        }


    }

    /**
     * 审核通过
     * @params $params  deal_opi...
     * @return mixed
     */
    public function reportSuccess($params) {
        if (!isset($params['report_id']))
            return ['code'=>500,'msg'=>'report_id必填'];

        unset($params['s']);
        $report_id =$params['report_id'];
        unset($params['report_id']);
//        $params['status'] = 4;
        $params['status'] = config('report-status.status.audit_pass');
        $edit = Report::reportEdit($report_id,$params);
        if ($edit) {
            //审核通过
            $report = Report::reportDetail(['report_id'=>$report_id]);
            //发站内信
            $inmail_params = ['user_id'=>$params['admin_id'],'receiver_id' => $report['to_admin_id'],'inmail_content'=>'公文:'.$report['report_title']."审核通过，请查看",'inmail_title'=>'有新的公文审核通过'];
            $inmail =  \InmailService::InmailAdd($inmail_params);
            return ['code' => 1, 'msg' => '审核通过'];
        }
        else
            return ['code' => 500, 'msg' => '审核出错'];
    }

    /**
     * 报告列表
     *
     * 分页
     */
    public function reportList($params) {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        if (isset($params['keyword'])) {
            if ($params['keyword'] == "")
                $params['keyword'] = null;
        } else
            $params['keyword'] = null;

        if (isset($params['status'])) {
            if ($params['status'] == "")
                $params['status'] = null;
        } else
            $params['status'] = null;

        if (isset($params['is_read'])) {
            if ($params['is_read'] == "")
                $params['is_read'] = null;
        } else
            $params['is_read'] = null;

        $data['limit'] = $params['limit'];
        $data['page'] = $params['page'];
        $data['keyword'] = $params['keyword'];
        $data['status'] = $params['status'];
        //role等级 1看所有 2看自己
        if ($params['r_level'] == 1) {
            $data['report_list'] = Report::reportList($params);
            $data['total'] = Report::reportCount($params);
            return ['code' => 1, 'data' => $data];
        }
        if ($params['r_level'] == 2) { //业主看自己 接收人
            $data['report_list'] = Report::reportListByUser($params);
            $data['total'] = Report::reportCountByUser($params);
            return ['code' => 1, 'data' => $data];
        }
        if ($params['r_level'] == 3) { //民警看自己 (自己是发送人)
            $data['report_list'] = Report::reportListByAdmin($params);
            $data['total'] = Report::reportCount($params);
            return ['code' => 1, 'data' => $data];
        }
    }

    //更新状态 是否已过期
    public function reportTimeRefresh() {
        $flag = 0;
        $report = Report::all();  //直接获取所有
        foreach ($report as $key => $value) {
            if ($value['status'] != config('report-status.status.audit_pass') && $value['status'] != config('report-status.status.overtime')&&$value['status']!=7) {  //审核未通过的 或者 已经超时了
                if (time()>strtotime($value['deal_time'])) {   //超时了
                    Report::reportEdit($value['report_id'],['status'=>config('report-status.status.overtime')]);
                    $flag += 1;
                }
            }
        }
        if ($flag==0)
            return ['code'=>10400,'msg'=>'状态无更新'];
        else
            return ['code'=>10401,'msg'=>'状态有更新'];

    }


    /**
     * 某一报告详细信息 + 回执
     * $params['admin_id']
     * $params['report_id']
     */
    public function reportDetail($params) {
        if (!isset($params['report_id']))
            return ['code'=>500,'msg'=>'report_id必填'];

        $report_find['report_id'] = $params['report_id'];
        $report = Report::reportDetail($report_find);
        if ($params['admin_id'] == $report['to_admin_id']) {  //如果是 接收人查看的
            Report::reportEdit($report_find['report_id'],['is_read'=>1]);//标记为已读
            //如果是未读状态（整改已发送）
            if ($report['status'] == config('report-status.status.send_rectify') ) {
                //编辑 变为整改中
                $params2['status'] = config('report-status.status.on_rectify');
                Report::reportEdit($report_find['report_id'],$params2);
            }
        }
        $files_info = array();

        $file_name = explode("|",$report['file_name']);
        $file_path = explode("|",$report['file_path']);

        for ($i=0;$i<count($file_name)-1;$i++) {
            //$report['files'] = ['file_name'=>$file_name[$i],'file_path'=>$file_path[$i]];
            array_push($files_info,['file_name'=>$file_name[$i],'file_path'=>config('system.files_domain').$file_path[$i]]);
        }
        $report['files_info'] = $files_info;
        $sys_id=explode(',',$report['sys_id']);
        $array1=[];
        foreach ($sys_id as $k=>$v){
            $data = ReportSystem::select( 'web_id')
                ->where('sys_id', $v)
                ->first();
            $array1[$k]['web_id']=$data['web_id'];
            $array1[$k]['sys_id']=$v;
        }
        $array2=[];
        foreach ($array1 as $k=>$v){
            $web=Web::select('web_name','web_id')
                ->where('web_id',$v['web_id'])
                ->first();
            $array2[$k]=$web;
            $array2[$k]['sys_id']=$v['sys_id'];
        }
        $report['web_info_list']=$array2;
        //回执的信息
        $list_condition = ['report_id'=>$params['report_id']];
        $report_list = Receipt::receiptList($list_condition);
            foreach ($report_list as $key =>$value) {
                $files_info2 = array();
                $file_name = $value['file_name'] ? explode("|",$value['file_name']) : [];
                $file_path = $value['file_path'] ? explode("|",$value['file_path']) : [];
                if($file_name){
                    foreach ($file_name as $k=>$v){
                        try {
                        $files_info2[$k]['file_name'] = $v;
                        $files_info2[$k]['file_path'] = config('system.files_domain').$file_path[$k];
                        } catch (\Exception $e) {
                            return ['code'=>'500','msg'=>'文件查询出错'];
                        }
                    }
                }
                $report_list[$key]['files_info'] = $files_info2;
            }
        $report['report_list'] = $report_list;
        return ['code'=>1,'msg'=>'查询成功','data'=>['info'=>$report]];
    }



    //TODO******************************************************   回执模块  ********************************************/
    /**
     * 回执添加
     * $params['report_id']
     * $params['report_info']
     * $params['admin_id']  jwt
     * $params['report_admin_id']  从report_id获取
     * $params['receipt_nick']     从公文 或者 admin表 获取
     * 0未读，1已读，2已回执，3回执未通过，4审核通过
     */
    public function receiptAdd($params) {
        if (!isset($params['report_id']))
            return ['code'=>500,'msg'=>'请先添加公文'];

        unset($params['s']);
        //获得公文所属人ID
        $report_admin_id = Report::reportDetail(['report_id'=>$params['report_id']]);
        $params['report_admin_id'] = $report_admin_id['to_admin_id'];


        //如果是民警直接回复 显示 请等待业主回执
        if ($params['report_admin_id'] != $params['admin_id']) {
            $count = Receipt::receiptUserCount(['report_id'=>$params['report_id']]);
            if ($count == 0) {
                return ['code'=>500,'msg'=>'请等待业主回执'];
            }
        }
        //判断report的status是否为4(审核已通过)
        $report_info = Report::reportDetail(['report_id'=>$params['report_id']]);
        if ($report_info['status'] ==config('report-status.status.audit_pass')) {
            return ['code'=>500,'msg'=>'审核已通过，无法添加回执'];
        }
        //获得发回执的人的nick
        if ($params['admin_id'] == $params['report_admin_id']) {  //如果是自己回复自己的公文(业主回执)
            $params['receipt_nick'] = $report_admin_id['company_name'];
            $inmail_params = ['user_id'=>$params['admin_id'],'receiver_id' => $report_admin_id['admin_id'],'inmail_content'=>$report_admin_id['report_name'],'inmail_title'=>'有新的公文回执'];
            \InmailService::InmailAdd($inmail_params);//回执发好后   站内信发给民警
        } else {  //如果是民警回复业主的回执(业主回执后-》民警再回执)
            $receipt_nick = Admin::adminDetail($params['admin_id']);
            $params['receipt_nick'] = $receipt_nick['admin_nick'];
            $inmail_params = ['user_id'=>$params['admin_id'],'receiver_id' => $params['report_admin_id'],'inmail_content'=>$report_admin_id['report_name'],'inmail_title'=>'有新的公文回执'];
            \InmailService::InmailAdd($inmail_params);//回执发好后   站内信发给业主
        }


        $add = Receipt::receiptAdd($params);
        if ($add) {
            //TODO 回执添加成功后修改 公文状态 如果是第一次的话 标为已回执  不是第一次的话 变为回执未通过
            //TODO 同一个公文的回执
            $count_params = ['report_id'=>$params['report_id']];
            $count = Receipt::receiptUserCount($count_params);
            if ($count ==1) {
                //编辑 变为已回执 (整改回执)
                $params2['status'] = config('report-status.status.receipt_rectify');
                Report::reportEdit($params['report_id'],$params2);
            }
            if ($count != 1) {
                //即民警回复业主(回执不通过)（再次整改回执）
                if ($params['report_admin_id'] != $params['admin_id']) {
                    $params3['status'] = config('report-status.status.send_rectify_again');
                    Report::reportEdit($params['report_id'],$params3);
                }
                //业主回复民警(回执不通过后再回执)（再次整改回执）
                if ($params['report_admin_id'] == $params['admin_id']) {
                    $params3['status'] = config('report-status.status.receipt_rectify_again');
                    Report::reportEdit($params['report_id'],$params3);
                }
            }
            return ['code' => 1, 'msg' => '回执添加成功'];
        }
        else
            return ['code' => 500, 'msg' => '回执添加失败'];
    }


    public function receiptEdit($params) {
        if (!isset($params['receipt_id']))
            return ['code'=>500,'msg'=>'receipt_id必填'];

        unset($params['s']);
        $receipt_id =$params['receipt_id'];
        unset($params['receipt_id']);
        $receipt = Receipt::receiptDetail(['receipt_id'=>$receipt_id]);
        if ($params['r_level'] == 2) {
            if ($receipt['admin_id'] != $params['admin_id']) {
                return ['code' => 500, 'msg' => '您不能编辑他人回执'];
            }
        }
        unset($params['r_level']);
        $edit = Receipt::receiptEdit($receipt_id,$params);
        if ($edit)
            return ['code' => 1, 'msg' => '回执编辑成功'];
        else
            return ['code' => 500, 'msg' => '回执编辑失败'];
    }


    public function receiptList($params) {
        $list_condition = ['report_id'=>$params['report_id']];
        $data['report_list'] = Receipt::receiptList($list_condition);
        return ['code' => 1,'msg'=>'查询成功' ,'data' => $data];
    }

    //编辑为已读
    public function receiptRead($params) {
        $res = ['code'=>1,'msg'=>'请求成功'];
        $condition = ['receipt_id' => $params['receipt_id']];

        $receipt = Receipt::receiptDetail($condition);
        $report = Report::reportDetail(['report_id'=>$receipt['report_id']]);
        //必须是公文的接收人或者发送人查看 才修改已读未读
        if (($params['admin_id'] == $report['examine_admin_id']) || ($params['admin_id'] == $report['to_admin_id'])) {
            if ($receipt['admin_id'] != $params['admin_id']) { //不是自己看自己的回执
                $receipt_edit = Receipt::receiptEdit($params['receipt_id'],['is_read'=>1]);
                if ($receipt_edit)
                    return ['code' => 1, 'msg' => '修改已读成功'];
                else
                    return ['code' => 500, 'msg' => '修改已读失败'];
            }
        }
        return $res;
    }


    //TODO******************************************************   民警审核模块  ********************************************/
    //民警审核公文列表
    public function reportListByExamine($params) {
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 20;
        $params['page'] = isset($params['page']) ? $params['page'] : 1;
        if (isset($params['keyword'])) {
            if ($params['keyword'] == "")
                $params['keyword'] = null;
        } else
            $params['keyword'] = null;

        if (isset($params['is_examine'])) {
            if ($params['is_examine'] == "")
                $params['is_examine'] = null;
        } else
            $params['is_examine'] = null;

        $data['limit'] = $params['limit'];
        $data['page'] = $params['page'];
        if ($params['r_level'] == 2) {
            //TODO 运维只能看自己
            $params['examine_add_admin_id'] = $params['admin_id'];
            $data['report_examine_list'] = ReportExamine::examineListBySelf($params);
            $data['total'] = ReportExamine::examineCountBySelf($params);
        } else {
            $data['report_examine_list'] = ReportExamine::examineList($params);
            $data['total'] = ReportExamine::examineCount($params);
        }
        return ['code' => 1, 'data' => $data];
    }

    //民警审核通过某个公文
    public function reportExamineEdit($params) {
        //TODO 1修改report_examine表字段
        //TODO 2修改report表的is_examine状态为审核通过 如果通过(不然不修改)
        if (!isset($params['examine_id']))
            return ['code'=>500,'msg'=>'examine_id必填'];
        unset($params['s']);
        $examine_id =$params['examine_id'];
        unset($params['examine_id']);
        $edit = ReportExamine::examineEdit($examine_id,$params);
        if ($edit) {
            if ($params['is_examine'] == config('report-status.is_examine.passed')) {
                //修改公文的is_examine字段和审核人字段
                $report_condition = ['examine_admin_id'=>$params['examine_admin_id'],"is_examine"=>$params['is_examine']];
                $report_examine_detail = ReportExamine::examineDetail(['examine_id'=>$examine_id]);
                $edit = Report::reportEdit($report_examine_detail['report_id'],$report_condition);

                //并且发站内信
                $report_info = Report::reportDetail(['report_id'=>$report_examine_detail['report_id']]);
                $inmail_params = ['user_id'=>$params['examine_admin_id'],'receiver_id' => $report_info['to_admin_id'],'inmail_content'=>$report_info['report_title'],'inmail_title'=>'有新的公文信息'];
                $inmail =  \InmailService::InmailAdd($inmail_params);
                //在admin_info表修改扫描次数
                $admin_info = AdminInfo::adminInfo($report_info['to_admin_id']);
                $scan_times = $admin_info['scan_times_count'] + $report_info['scan_times'];
                AdminInfo::adminInfoChange($report_info['to_admin_id'],['scan_times_count'=>$scan_times]);
            }
            return ['code' => 1, 'msg' => '审核公文成功'];
        }
        else
            return ['code' => 500, 'msg' => '审核公文失败'];
    }

    //民警修改待发布前的公文
    public function reportEditByExamine($params) {
        if (!isset($params['report_id']))
            return ['code'=>500,'msg'=>'report_id必填'];

        unset($params['s']);
        $report_id =$params['report_id'];unset($params['report_id']);
        $examine_id = $params['examine_id']; unset($params['examine_id']);
        $edit_examine = ReportExamine::examineEdit($examine_id,['report_name'=>$params['report_name'], 'police_id'=>$params['police_id']]);
        $edit = Report::reportEdit($report_id,$params);
        if ($edit)
            return ['code' => 1, 'msg' => '公文编辑成功', 'data'=> $edit_examine];
        else
            return ['code' => 500, 'msg' => '公文编辑失败'];
    }
    //查询异常系统列表
    public function sysList($params){
        $data = Report::sysList($params);
        if(empty($data)){
            return ['code'=>90003,'msg'=>'该业主暂无异常列表'];
        }
        if(isset($params['limit'])){
            $data['limit'] = $params['limit'];
        }
        $res = ReportSystem::sysListAll($data);
        if($res){
            return ['code'=>1,'data'=>$res];
        }else{
            return ['code'=>90003,'msg'=>'查询失败'];
        }
    }
}
