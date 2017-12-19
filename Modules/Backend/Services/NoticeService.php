<?php
/**
 * Created by PhpStorm.
 * User: 张燕
 * Date: 2017/10/30
 * Time: 17:14
 */

namespace Modules\Backend\Services;

use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Not;
use Modules\Backend\Models\Admin;
use Modules\Backend\Models\Notice;

class NoticeService
{
    /**
     * 公告列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function noticeList($params)
    {
        $res = Notice::noticeList($params);
        $result['data']['notice_list'] = $res['list'];
        $result['data']['total'] = $res['total'];
        $result['data']['page'] = $res['page'];
        $result['code'] = 1;
        return $result;
    }
    /**
     * 添加公告
     * string $notice_title 公告标题
     * string $notice_content 公告内容
     * string $admin_id 操作员ID
     * @return array
     */
    public function noticeAdd($params)
    {
        $validator = \Validator::make($params,[
           'notice_title' => 'required' ,
            'notice_content' => 'required'
        ],[
            'required' => ':attribute为必填项',
            'min' => ':attribute长度不符合要求',
            'max' => ':attribute长度不符合要求'
        ],[
            'notice_title' => '公告标题' ,
            'notice_content' => '公告内容'
        ]);
        if($validator->fails()){
            return ['code' => 90002 , $validator->messages()->first()];
        }
        $isadd = Notice::noticeAdd($params);
        if($isadd){
            return ['code' => 1 , 'msg' => '新增成功'];
        }else{
            return ['code' => 10100 , 'msg' => '新增失败'];
        }
    }
    /**
     * 编辑公告
     * string $notice_title 公告标题
     * string $notice_content 公告内容
     * string $admin_id 操作员ID
     * @return array
     */
    public function noticeEdit($params)
    {
        $validator = \Validator::make($params,[
            'notice_title' => 'required' ,
            'notice_content' => 'required'
        ],[
            'required' => ':attribute为必填项',
            'min' => ':attribute长度不符合要求',
            'max' => ':attribute长度不符合要求'
        ],[
            'notice_title' => '公告标题' ,
            'notice_content' => '公告内容'
        ]);
        if($validator->fails()){
            return ['code' => 90002 ,'msg'=> $validator->messages()->first()];
        }
        $isadd = Notice::noticeEdit($params);
        if($isadd){
            return ['code' => 1 , 'msg' => '修改成功'];
        }else{
            return ['code' => 10101 , 'msg' => '修改失败'];
        }
    }
    /**
     * 删除公告
     * string $notice_id 公告ID
     * @return array
     */
    public function noticeDelete($params)
    {
        if(!isset($params['notice_id'])){
            return ['code'=>90002,'msg'=>'公告ID必填'];
        }
        $isdelete = Notice::noticeDelete($params);
        if($isdelete){
            return ['code'=>1,'msg'=>'删除成功'];
        }else{
            return ['code'=>10102,'msg'=>'删除失败'];
        }
    }
    /**
     * 公告详情
     * string $notice_id 公告ID
     * @return array
     */
    public function noticeDetail($params)
    {
        if(!isset($params['notice_id'])){
            return ['code'=>90002,'msg'=>'公告ID必填'];
        }
        $data = Notice::noticeDetail($params);
        $admin = Admin::adminDetail($data['admin_id']);
        $data['admin_nick'] = $admin->admin_nick;
        if($data){
            return ['code'=>1,'data'=>['notice_detail'=>$data]];
        }else{
            return ['code'=>10103,'msg'=>'查询失败'];
        }
    }
    /**
     * 最新公告
     * string $notice_title 公告标题
     * string $notice_content 公告内容
     * string $admin_id 操作员ID
     * @return array
     */
    public function noticeNew()
    {
        $data = Notice::noticeNew();
        foreach ($data as $key => $value){
            $admin = Admin::adminDetail($value['admin_id']);
            $data[$key]['admin_nick'] = $admin->admin_nick;
        }
        return ['code'=>1,'data'=>['notice_new'=>$data]];
    }

}