<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['1', 'onDuty', '值班概述', '值班概述', '0', '1', '/onDuty', '1', '2017-11-01 10:42:14', '2017-11-07 09:08:15'],

            ['3', 'schedule', '值班信息', '值班信息', '1', '2', '', '1', '2017-11-01 10:44:16', '2017-11-01 10:44:16'],

            ['4', 'scheduleEdit', '值班编辑', '值班编辑', '3', '3', '', '1', '2017-11-01 10:44:58', '2017-11-01 10:44:58'],

            ['5', 'owner', '业主情况', '业主情况', '0', '1', '/owner', '1', '2017-11-01 10:46:50', '2017-11-01 10:51:34'],

            ['6', 'todo', '待办事务', '待办事务', '0', '1', '/todo', '1', '2017-11-01 10:52:41', '2017-11-06 18:31:57'],

            ['7', 'file', '公文流转', '公文流转', '0', '1', '/file', '1', '2017-11-01 10:53:09', '2017-11-03 15:07:53'],

            ['8', 'network', '网络预警', '网络预警', '0', '1', '/network', '1', '2017-11-01 11:01:21', '2017-11-01 11:01:21'],

            ['9', 'log', '日志管理', '日志管理', '0', '1', '/log', '1', '2017-11-01 11:02:15', '2017-11-01 11:02:15'],

            ['10', 'rbac', '权限管理', '权限管理', '0', '1', '/rbac', '1', '2017-11-01 11:03:43', '2017-11-01 11:03:43'],

            ['11', 'clientInfo', '业主概述', '业主概述', '5', '2', '/owner/overview', '1', '2017-11-01 11:04:59', '2017-11-06 17:58:24'],

            ['12', 'clientInfoCount', '业主统计', '业主统计', '5', '2', '/owner/statistics', '1', '2017-11-01 11:10:07', '2017-11-07 13:26:24'],

            ['15', 'clientInfoList', '业主概述列表', '业主概述列表', '11', '3', '', '1', '2017-11-06 17:58:43', '2017-11-06 18:34:17'],

            ['16', 'affair', '事务列表', '事务列表', '6', '2', '/todo/list', '1', '2017-11-01 11:23:23', '2017-11-06 17:40:04'],

            ['17', 'affairAll', '全部事务', '全部事务', '16', '3', '', '1', '2017-11-01 11:25:38', '2017-11-06 17:50:42'],

            ['18', 'finishedAll', '已完成事务', '已完成事务', '16', '3', '', '1', '2017-11-06 18:30:33', '2017-11-06 18:30:33'],

            ['19', 'unfinishedAll', '未完成事务', '未完成事务', '16', '3', '', '1', '2017-11-06 18:32:36', '2017-11-06 18:32:36'],

            ['22', 'reportAdd', '添加公文', '添加公文', '45', '3', '/file/All', '1', '2017-11-01 11:30:25', '2017-11-01 11:30:25'],

            ['23', 'reportEdit', '编辑公文', '编辑公文', '45', '3', '/file/Fail', '1', '2017-11-01 11:31:31', '2017-11-01 11:31:31'],

            ['24', 'reportList', '公文列表', '传输成功公文', '45', '3', '/file/Passed', '1', '2017-11-01 11:32:01', '2017-11-01 11:32:01'],

            ['25', 'reportDetail', '公文详情', '某一报告详细信息 + 回执', '45', '3', '', '1', '2017-11-01 11:32:48', '2017-11-01 11:32:48'],

            ['26', 'receiptAdd', '回执添加', '回执添加', '45', '3', '', '1', '2017-11-01 11:33:29', '2017-11-01 11:33:29'],

            ['27', 'receiptEdit', '回执编辑', '回执编辑', '45', '3', '', '1', '2017-11-01 11:33:47', '2017-11-01 11:33:47'],

            ['28', 'noticeNew', '最新预警', '最新预警', '8', '2', '/network/new', '1', '2017-11-01 11:37:54', '2017-11-07 11:50:07'],

            ['29', 'networkPast', '往期预警', '往期预警', '8', '2', '/network/past', '1', '2017-11-01 11:38:25', '2017-11-07 10:59:12'],

            ['33', 'permission', '权限管理', '权限管理', '10', '2', '/rbac/permission', '1', '2017-11-01 11:42:37', '2017-11-07 11:47:42'],

            ['34', 'role', '角色管理', '角色管理', '10', '2', '/rbac/role', '1', '2017-11-01 11:43:19', '2017-11-07 11:47:56'],

            ['35', 'admin', '用户管理', '用户管理', '10', '2', '/rbac/users', '1', '2017-11-01 11:44:44', '2017-11-06 13:50:00'],

            ['36', 'mail', '站内信管理', '站内信', '0', '1', '', '0', '2017-11-03 13:56:33', '2017-11-07 10:11:16'],

            ['37', 'inmail', '站内信', '站内信信息', '36', '2', '', '1', '2017-11-08 10:29:13', '2017-11-07 13:18:40'],

            ['38', 'inmailList', '站内信列表', '站内信列表', '37', '3', '', '1', '2017-11-03 13:57:03', '2017-11-03 13:57:03'],

            ['39', 'inmailAdd', '发送站内信', '发送站内信', '37', '3', '', '1', '2017-11-03 13:58:18', '2017-11-03 13:58:18'],

            ['41', 'inmailDelete', '删除站内信', '删除站内信', '37', '3', '', '1', '2017-11-03 13:58:40', '2017-11-03 13:58:40'],

            ['44', 'inmailDetail', '信息详情查看', '站内信信息详情', '37', '3', '', '1', '2017-11-03 14:00:02', '2017-11-08 11:28:16'],

            ['45', 'report', '公文管理', '公文回执控制器', '7', '2', '', '1', '2017-11-03 15:02:36', '2017-11-03 15:02:50'],

            ['46', 'scheduleAdd', '班次批量添加', '批量的班次添加-附带排班初始化', '3', '3', '', '1', '2017-11-03 15:01:17', '2017-11-07 09:26:39'],

            ['47', 'downloadRecord', '下载记录', '下载记录', '45', '3', '', '1', '2017-11-03 15:33:34', '2017-11-03 15:33:41'],

            ['48', 'reportSuccess', '审核通过', '审核通过', '45', '3', '', '1', '2017-11-03 15:36:12', '2017-11-03 15:36:15'],

            ['49', 'scheduleWeekList', '周排班信息', '一周排班的信息', '3', '3', '', '1', '2017-11-03 16:08:55', '2017-11-03 16:08:55'],

            ['50', 'scheduleDetail', '班次详情', '班次详情', '3', '3', '', '1', '2017-11-03 16:09:47', '2017-11-03 16:09:47'],

            ['51', 'scheduleNow', '当前值班者', '当前时间值班人员信息', '3', '3', '', '1', '2017-11-03 16:10:34', '2017-11-07 09:24:39'],

            ['52', 'adminList', '用户列表', '用户列表', '35', '3', '', '1', '2017-11-06 13:50:22', '2017-11-06 13:50:57'],

            ['53', 'adminAdd', '用户添加', '用户添加', '35', '3', '', '1', '2017-11-06 13:50:46', '2017-11-06 13:50:46'],

            ['54', 'adminEdit', '用户编辑', '用户编辑', '35', '3', '', '1', '2017-11-06 13:51:34', '2017-11-06 13:51:34'],

            ['56', 'adminDetail', '用户详情', '用户详情', '35', '3', '', '1', '2017-11-06 13:58:37', '2017-11-06 13:58:37'],

            ['57', 'roleAdd', '角色添加', '角色添加', '34', '3', '', '1', '2017-11-06 14:00:13', '2017-11-06 14:00:13'],

            ['58', 'roleEdit', '角色编辑', '角色编辑', '34', '3', '', '1', '2017-11-06 14:00:37', '2017-11-06 14:00:37'],

            ['60', 'roleList', '角色列表', '角色列表', '34', '3', '', '1', '2017-11-06 14:01:09', '2017-11-06 14:01:09'],

            ['61', 'roleDetail', '角色详细', '角色详细', '34', '3', '', '1', '2017-11-06 14:01:23', '2017-11-06 14:01:23'],

            ['62', 'permissionList', '权限列表', '权限列表', '33', '3', '', '1', '2017-11-06 14:07:17', '2017-11-06 14:07:17'],

            ['63', 'permissionDetail', '权限详细', '权限详细', '33', '3', '', '1', '2017-11-06 14:07:33', '2017-11-06 14:07:33'],

            ['64', 'logAll', '日志信息', '日志信息', '9', '2', '/log/log', '1', '2017-11-06 15:14:24', '2017-11-06 15:14:24'],

            ['65', 'logList', '日志列表', '日志列表', '64', '3', '', '1', '2017-11-06 15:15:08', '2017-11-06 15:15:08'],

            ['66', 'logDetail', '日志详情', '日志详情', '64', '3', '', '1', '2017-11-06 15:15:39', '2017-11-06 15:15:39'],

            ['67', 'noticeAdd', '添加预警', '添加预警', '29', '3', '', '1', '2017-11-06 15:18:17', '2017-11-06 15:18:17'],

            ['68', 'noticeEdit', '编辑预警', '编辑预警', '29', '3', '', '1', '2017-11-06 15:20:54', '2017-11-06 15:20:54'],

            ['70', 'noticeDetail', '查看预警详情', '查看预警详情', '29', '3', '', '1', '2017-11-06 15:21:47', '2017-11-06 15:22:00'],

            ['71', 'permissionAdd', '权限添加', '权限添加', '33', '3', '', '1', '2017-11-06 15:31:27', '2017-11-06 15:31:27'],

            ['72', 'permissionEdit', '权限编辑', '权限编辑', '33', '3', '', '1', '2017-11-06 15:31:49', '2017-11-06 15:31:49'],

            ['74', 'permissionRoleList', '角色权限列表', '角色权限列表', '33', '3', '', '1', '2017-11-06 16:07:49', '2017-11-06 16:07:49'],

            ['75', 'permissionRoleAdd', '角色权限添加', '角色权限添加', '33', '3', '', '1', '2017-11-06 16:08:08', '2017-11-06 16:08:08'],

            ['76', 'permissionRoleDetail', '角色权限详细', '角色权限详细', '33', '3', '', '1', '2017-11-06 16:08:29', '2017-11-06 16:08:29'],

            ['82', 'weekScheduleAdd', '排班初始化', '初始化某一周排班', '3', '3', '', '1', '2017-11-07 09:22:19', '2017-11-07 09:22:19'],

            ['83', 'scheduleList', '总排班信息', '总排班信息列表', '3', '3', '', '1', '2017-11-07 09:24:02', '2017-11-07 09:24:02'],

            ['84', 'scheduleAddSingle', '班次添加', '针对时间添加上班人员、使用前请初始化排班', '3', '3', '', '1', '2017-11-07 09:27:52', '2017-11-07 09:27:52'],

            ['85', 'noticeList', '预警列表', '预警列表', '29', '3', '', '1', '2017-11-07 10:24:54', '2017-11-07 10:24:54'],

            ['86', 'fileUpLoad', '文件上传', '文件上传', '45', '3', '', '1', '2017-11-07 13:18:11', '2017-11-07 13:18:11'],

            ['87', 'scheduleDelete', '班次删除', '班次删除', '3', '3', '', '1', '2017-11-08 14:09:32', '2017-11-09 15:34:30'],
        ];

        $field = ['id','name','display_name','description','pid','level','path','show','created_at','updated_at'];

        DB::table('permissions')->insert(sql_batch_str($field,$data));
    }
}