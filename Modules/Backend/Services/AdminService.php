<?php
/**
 * 管理员模块
 * Author: 葛宏华
 * Date: 2017/7/25
 */

namespace Modules\Backend\Services;

use Modules\Backend\Models\Admin;
use Modules\Backend\Models\AdminInfo;
use Modules\Backend\Models\AdminRecord;
use Modules\Backend\Models\Permission;
use Modules\Backend\Models\RoleAdmin;
use Modules\Backend\Models\Web;
use Modules\Backend\Models\WorkScheduleAllot;
use Illuminate\Support\Facades\DB;
use Modules\Backend\Models\Role;
use JWTAuth;
use Session;

class AdminService
{
    /**
     * 民警 列表
     */
    public function policeList()
    {
        $police = DB::table('admins')->join('role_admin', 'admins.admin_id', '=', 'role_admin.admin_id')
            ->select('admins.admin_id', 'admins.admin_name', 'admins.admin_nick')->where('role_admin.role_id', '=', '2')
            ->where('admins.admin_id', '!=', '1')
            ->get();
        if ($police) {
            $data['list'] = $police;
            $data['code'] = 1;
            $data['msg'] = '查询成功';
        } else {
            $data['code'] = 90002;
            $data['msg'] = '查询失败';
        }
        return $data;
    }

    /**
     * 登录返回role_id
     */
    public function adminRoleid($params)
    {
        $police = DB::table('admins')->join('role_admin', 'admins.admin_id', '=', 'role_admin.admin_id')
            ->select('role_admin.role_id')
            ->where('role_admin.admin_id', '=', $params['admin_id'])
            ->get();
        return $police;
    }

    /**
     * 管理员 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @return array
     */
    public function adminList($params)
    {
        $res = Admin::adminList($params);

        $list = $res['list'];
        $admin_id_array = [];
        foreach ($list as $key => $value) {
            $admin_id_array[] = $list[$key]['admin_id'];
        }

        $info = AdminInfo::adminInfoList($admin_id_array);
        foreach ($list as $key => $value) {
            foreach ($info as $k => $v) {
                if ($list[$key]['admin_id'] == $info[$k]['admin_id']) {
                    $temp = [
                        'scan_times' => $info[$k]['scan_times'],
                        'admin_url' => $info[$k]['admin_url'],
                        'risk_level' => $info[$k]['risk_level'],
                        'company_name' => $info[$k]['company_name'],
                        'position' => $info[$k]['position'],
                        'department' => $info[$k]['department'],
                    ];
                    $list[$key] = array_merge($list[$key], $temp);
                }
            }
        }

        $result['data']['admin_list'] = $list;
        $result['data']['total'] = $res['total'];
        $result['data']['pages'] = $res['pages'];
        $result['code'] = 1;
        return $result;
    }

    /**
     * 管理员  添加
     * @params string $admin_name 账号
     * @params string $admin_password 密码
     * @return array
     */
    public function adminAdd($params)
    {
        $validator = \Validator::make($params, [
            'admin_name' => 'required|unique:admins|min:5|max:20',
            'admin_password' => 'required|min:6',
            'role_id' => 'required',
            'company_name' => 'required',
            'contact_name' => 'required',
            'contact_mobile' => 'required',
        ], [
            'required' => ':attribute为必填项',
            'min' => ':attribute长度不符合要求',
            'unique' => ':attribute必须唯一'
        ], [
            'admin_name' => '账号',
            'admin_password' => '密码',
            'role_id' => '分配角色',
            'company_name' => '单位名称',
            'contact_name' => '联系人名字',
            'contact_mobile' => '联系人手机号',
        ]);
        if ($validator->passes()) {
            if (!Admin::adminExist($params['admin_name'])) {
                if (AdminInfo::adminInfoExist($params['company_name'])) {
                    $result['code'] = 10004;
                    $result['msg'] = '一个公司只能有一个账号';
                } else {
                    if ($params['role_id']) {
                        DB::beginTransaction();
                        $res1 = Admin::adminAdd($params);
                        #用户权限
                        $params2['admin_id'] = $res1;
                        $params2['role_id'] = $params['role_id'];
                        $res2 = RoleAdmin::roleAdminAdd($params2);
                        #关联用户信息
                        $params3['admin_id'] = $res1;
                        $params3['company_name'] = $params['company_name'];
                        if (isset($params['position'])) {
                            $params3['position'] = $params['position'];
                        }
                        if (isset($params['department'])) {
                            $params3['department'] = $params['department'];
                        }
                        if (isset($params['contact_name'])) {
                            $params3['contact_name'] = $params['contact_name'];
                        }
                        if (isset($params['contact_mobile'])) {
                            $params3['contact_mobile'] = $params['contact_mobile'];
                        }
                        $res3 = AdminInfo::adminInfoAdd($params3);
                        if ($res1 && $res2 && $res3) {
                            DB::commit();
                            $result['code'] = 1;
                            $result['msg'] = '添加成功';
                        } else {
                            DB::rollback();
                            $result['code'] = 10001;
                            $result['msg'] = '添加用户失败';
                        }
                    } else {
                        $result['code'] = 10007;
                        $result['msg'] = '请添加用户权限';
                    }
                }
            } else {
                $result['code'] = 10004;
                $result['msg'] = '该管理账号已存在';
            }
        } else {
            $result['code'] = 90002;
            $result['msg'] = $validator->messages()->first();
        }

        return $result;
    }

    /**
     * 管理员  编辑
     * @params int $admin_id 管理员ID
     * @params string $admin_password 密码
     * @return array
     */
    public function adminEdit($params)
    {
        $validator = \Validator::make($params, [
            'admin_id' => 'required',
            'admin_name' => 'required',
            'admin_sex' => 'required',
            'contact_name' => 'required',
            'contact_mobile' => 'required',
            //'admin_password' => 'required|min:6',
            'role_id' => 'required',
        ], [
            'required' => ':attribute为必填项',
            'min' => ':attribute长度不符合要求',
            'unique' => ':attribute必须唯一'
        ], [
            'admin_id' => '管理员id',
            'admin_name' => '昵称',
            'admin_sex' => '性别',
            'contact_name' => '联系人名称',
            'contact_mobile' => '联系人手机号',
            //'admin_password' => '密码',
            'role_id' => '分配角色'
        ]);
        if (!$validator->passes()) {
            $result['code'] = 90002;
            $result['msg'] = $validator->messages()->first();
            return $result;
        }
        DB::beginTransaction();
        $res1 = Admin::adminEdit($params);
        if (isset($params['role_id'])) {
            #用户权限  先删除再插入
            $res2 = RoleAdmin::roleAdminDelete($params['admin_id']);
            $params3['admin_id'] = $params['admin_id'];
            $params3['role_id'] = $params['role_id'];
            $res3 = RoleAdmin::roleAdminAdd($params3);
        } else {
            $res2 = $res3 = true;
        }

        #info表信息修改
        $res4 = AdminInfo::adminInfoEdit($params);

        if ($res1 != false && $res2 !== false && $res3 && $res4) {
            DB::commit();
            $result['code'] = 1;
            $result['msg'] = '编辑成功';
        } else {
            DB::rollback();
            $result['code'] = 10002;
            $result['msg'] = '编辑失败';
        }

        return $result;
    }

    /**
     * 管理员  详情
     * @params int $admin_id 管理员ID
     * @return array
     */
    public function adminDetail($admin_id)
    {
        #已有角色
        $has_role_list = RoleAdmin::adminRoleID($admin_id);
        #所有角色
        $role_list = Role::roleListAll();
        #该管理员的信息
        $res = Admin::adminDetail($admin_id);
        if (empty($res)) {
            return ['code' => 10315, "msg" => '用户不存在'];
        } else {
            $res = $res->toArray();
        }
        #info信息
        $info = AdminInfo::adminInfo($admin_id)->toArray();

        foreach ($info as $k => $v) {
            if ($k == "updated_at" || $k == "created_at") {
            } else {
                $res[$k] = $v;
            }
        }

        $res['role_list'] = $role_list;
        $res['has_role_list'] = $has_role_list;
        $result['data']['admin_info'] = $res;
        $result['code'] = 1;
        return $result;
    }

    /**
     * 管理员  删除
     * @params int $admin_id 管理员ID
     * @return array
     */
    public function adminDelete($params)
    {
        DB::beginTransaction();
        $res = Admin::adminDelete($params['admin_id']);
        $res1 = AdminInfo::adminInfoDel($params);
        $res2 = WorkScheduleAllot::scheduleDelete($params);
        if ($res && $res1 && $res2) {
            DB::commit();
            $result['code'] = 1;
            $result['msg'] = '删除成功';
        } else {
            DB::rollback();
            $result['code'] = 10003;
            $result['msg'] = '删除失败';
        }
        return $result;
    }
    #连续登录失败5次，等10分钟在登录
    public function getLoginFail($data){
        #连续登录失败5次，等10分钟在登录
        $record_info = AdminRecord::where('admin_id', $data)
            ->orderBy('updated_at', 'asc')
            ->get()
            ->toArray();
        foreach ($record_info as &$v) {
            $v['time'] = strtotime($v['updated_at']);
        }
        #判断总个数是否有五个
        if (count($record_info) > 4) {
            #取最后五个
            $data = array_slice($record_info, -5, 5);
            #判断是否连续
            $record_status = array();
            for ($i = 0; $i < 5; $i++) {
                if ($data[$i]['record_status'] == 1) {
                    $record_status[] = $data[$i];
                }
            }
            if (count($record_status) == 0) {
                #判断五个值是否在同一个十分钟呢
                $time = $data[4]['time'] - $data[0]['time'];
                if($time<=600){
                    #当前登录的时间与最后一个时间相比较是否超过十分钟
                    if((time()-$data[4]['time'])<600){
                        return ['code' => 10009, 'msg' => '您已经连续五次密码输入错误,请十分钟之后在试'];
                    }
                }
            }
        }
    }

    /**
     * 管理员  登录
     * @params string $admin_name 管理员账号
     * @params string $admin_password 管理员密码
     * @return array
     */
    public function adminLogin($params)
    {
        $admin_info = Admin::adminInfo($params['admin_name']);
        #判断是否连续登录失败5次，等10分钟在登录
        $res=$this->getLoginFail($params['admin_name']);
        if($res){
            return $res;
        }
        if ($admin_info) {
            if (password_verify($params['admin_password'], $admin_info['admin_password'])) {
                $result['code'] = 1;
                $result['msg'] = '登录成功';
                #登录成功记录
                $record = [];
                $record['admin_id'] = $params['admin_name'];
                $record['record_status'] = 1;
                $record['record_ip'] = $params['record_ip'];
                \AdminRecordService::recordAdd($record);
                // 等级信息查询
                $role = RoleAdmin::roleAdminDetail($admin_info['admin_id'])->toArray();
                $r_level = '';
                foreach ($role as $item) {
                    $roleData = Role::roleDetail($item['role_id'])->toArray();
                    $r_level = $roleData['r_level'];
                    if ($r_level == 1) {
                        break;
                    }
                }
                $customClaim = [
                    'from' => 'admin',
                    'admin_id' => $admin_info['admin_id'],
                    'admin_nick' => $admin_info['admin_nick'],
                    'r_level' => $r_level
                ];
                $token = JWTAuth::fromUser($admin_info, $customClaim);
                $result['data']['token'] = $token;
                $result['data']['admin_id'] = $admin_info['admin_id'];
                $result['data']['admin_nick'] = $admin_info['admin_nick'];
                $result['data']['is_first'] = $admin_info['is_first'] == 1 ? false : true;
                $role_id = DB::table('admins')->join('role_admin', 'admins.admin_id', '=', 'role_admin.admin_id')
                    ->select('role_admin.role_id')
                    ->where('role_admin.admin_id', '=', $admin_info['admin_id'])
                    ->get()
                    ->toArray();
                $result['data']['role_id'] = $role_id[0]->role_id;
                $result['data']['r_level'] = $customClaim['r_level'];
                $result['permission_list'] = Permission::permissionAdminAll($admin_info['admin_id']);

            } else {
                #登录失败记录
                $record = [];
                $record['admin_id'] = $params['admin_name'];
                $record['record_status'] = 2;
                $record['record_ip'] = $params['record_ip'];
                \AdminRecordService::recordAdd($record);
                $result['code'] = 10005;
                $result['msg'] = '账号密码不正确';
            }

        } else {
            #登录失败记录
            $record = [];
            $record['admin_id'] = $params['admin_name'];
            $record['record_status'] = 2;
            $record['record_ip'] = $params['record_ip'];
            \AdminRecordService::recordAdd($record);
            $result['code'] = 10006;
            $result['msg'] = '该账号不存在或已删除';
        }
        return $result;
    }

    /**
     * 用户密码修改
     * @params int $admin_id 用户id
     * @params string $admin_password 用户密码
     * @params string $admin_password_change 用户修改后的密码
     * @return array
     */
    public function adminChangePassword($params)
    {
        if (!isset($params['admin_password_change'])) {
            return ['code' => 90002, 'msg' => '修改密码参数必传'];
        }
        if (!matchPwd($params['admin_password_change'])) {
            return ['code' => 90002, 'msg' => '必须包含大小写数字特殊符号'];
        }

        $admin = Admin::find($params['admin_id']);

        if (!password_verify($params['admin_password'], $admin['admin_password'])) {
            return ['code' => 10005, 'msg' => '原密码错误、账号密码错误'];
        } else {
            $data = [
                'admin_id' => $params['admin_id'],
                'admin_password' => bcrypt($params['admin_password_change']),
            ];
            $res = Admin::adminPasswordEdit($data);
            if ($res) {
                return ['code' => 1, 'msg' => '修改成功'];
            } else {
                return ['code' => 10008, 'msg' => '修改密码失败'];
            }
        }
    }

    /**
     * 所有用户
     */
    public function adminListAll($params)
    {
        $list = Admin::select(['admin_id', 'admin_name', 'admin_nick', 'admin_sex', 'created_at', 'admin_birthday'])
            ->orderBy('admin_id', 'ASC')
            ->get()->toArray();

        $admin_id_array = [];
        foreach ($list as $key => $value) {
            $admin_id_array[] = $list[$key]['admin_id'];
        }

        $info = AdminInfo::adminInfoList($admin_id_array);
        foreach ($list as $key => $value) {
            foreach ($info as $k => $v) {
                if ($list[$key]['admin_id'] == $info[$k]['admin_id']) {
                    $temp = [
                        'scan_times' => $info[$k]['scan_times'],
                        'admin_url' => $info[$k]['admin_url'],
                        'risk_level' => $info[$k]['risk_level'],
                        'company_name' => $info[$k]['company_name'],
                        'position' => $info[$k]['position'],
                        'department' => $info[$k]['department'],
                    ];
                    $list[$key] = array_merge($list[$key], $temp);
                }
            }
        }

        return ['code' => 1, 'data' => $list];
    }

    public function login($params)
    {
        \Log::info($params);
        // 验证码
        $key = $params['verification_code'];
        $key = (string)$key;

        \Log::info(session($key));
        \Log::info(Session::get($key));
        $value111 = Session::all();
        \Log::info($value111);

        if (session($key) != $params['code']) {
            return ["code" => 10000, "msg" => "验证码错误", 'asd' => session($key)];
        } else {
            return ['code' => 1, "msg" => '通过'];
        }
    }
    /**
     * 添加业主网站
     */
    public function webAdd($params){
        $validator = \Validator::make($params,[
            'admin_id' => 'required' ,
            'web_name' => 'required',
            'web_link' => array('regex:/(http?|https?):\/\/.([^\.\/]+)\.(\/[\w-\.\/\?\%\&\=]*)?/i')
        ],[
            'required' => ':attribute为必填项',
            'regex' => ':attribute格式不正确'
        ],[
            'admin_id' => '业主ID' ,
            'web_name' => '网站名称',
            'web_link' => '网站链接（以http://或者https://开头）'
        ]);
        if($validator->fails()){
            return ['code' => 90002 ,'msg'=> $validator->messages()->first()];
        }
        $res = Web::webAdd($params);
        if($res){
            return ['code'=>1,'msg'=>'添加成功'];
        }else{
            return ['code'=>90003,'msg'=>'操作失败'];
        }
    }
    /**
     * 编辑业主网站
     */
    public function webEdit($params){
        $validator = \Validator::make($params,[
            'web_id' => 'required' ,
            'admin_id' => 'required' ,
            'web_name' => 'required',
            'web_link' => array('regex:/(http?|https?):\/\/.([^\.\/]+)\.(\/[\w-\.\/\?\%\&\=]*)?/i')
        ],[
            'required' => ':attribute为必填项',
            'regex' => ':attribute格式不正确'
        ],[
            'web_id' => '网站ID' ,
            'admin_id' => '业主ID' ,
            'web_name' => '网站名称',
            'web_link' => '网站链接（以http://或者https://开头）'
        ]);
        if($validator->fails()){
            return ['code' => 90002 ,'msg'=> $validator->messages()->first()];
        }
        $res = Web::webEdit($params);
        if($res){
            return ['code'=>1,'msg'=>'编辑成功'];
        }else{
            return ['code'=>90003,'msg'=>'编辑失败'];
        }
    }
    /**
     * 删除业主网站
     */
    public function webDelete($params){
       if(!isset($params['web_id'])){
           return ['code'=>90003,'msg'=>'网站ID必填'];
       }
       $res = Web::webDelete($params);
        if($res){
            return ['code'=>1,'msg'=>'删除成功'];
        }else{
            return ['code'=>90003,'msg'=>'删除失败'];
        }
    }
    /**
     * 业主网站列表
     */
    public function webList($params){
        $list= Web::webList($params);
        if($list){
            return ['code'=>1,'data'=>$list];
        }else{
            return ['code'=>90003,'msg'=>'查询失败'];
        }
    }

    // 项目初始化
    public function projectInitialize()
    {

    }

}
