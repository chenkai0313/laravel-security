<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function ($api) {
    #无需身份验证
    $api->group(['namespace' => 'Modules\Backend\Http\Controllers','prefix' => 'backend','middleware'=>['session_start']], function ($api) {
        // 验证码调试接口
//        $api->get('check','AdminController@check_code');
        // 验证码正式接口
//        $api->get('code/{tmp}','AdminController@qrcode');
//        $api->post('account-login-list', 'AdminController@login');
        // 初始化项目
       // $api->get()
    });
    #需要身份验证
    $api->group(['namespace' => 'Modules\Backend\Http\Controllers','prefix' => 'backend','middleware'=>['jwt-admin','log-admin','session_start']], function ($api) {
        #站内信
        $api->post('inmail-add','InmailController@inmailAdd');              //发送站内信
        $api->post('inmail-editstatus','InmailController@inmailEditStatus');//修改站内信状态（未读->已读 支持批量修改）
        $api->post('inmail-delete','InmailController@inmailDelete');        //删除站内信，支持批量删除
        $api->get('inmail-searchuser','InmailController@inmailSearchUser'); //模糊查找用户
        $api->get('inmail-list','InmailController@inmailList');             //站内信列表
        $api->get('inmail-unreadcount','InmailController@inmailUnreadCount');   //当前存在未读信息个数
        $api->get('inmail-detail','InmailController@inmailDetail');             //站内信详情
        #业主情况
        $api->get('clientinfo-list','ClientInfoController@clientInfoList');     //业主概况
        $api->get('client-detail','ClientInfoController@clientDetail');     //业主概况
        $api->get('sys-list','ReportController@sysList');     //异常系统列表
        $api->get('system-bugdetail','ReportController@reportSystemDetailByOwner');     //异常系统列表(业主情况)
        // $api->post('clientinfo-edit','ClientInfoController@clientInfoEdit');       //业主概况编辑  废弃
        // $api->post('clientinfo-delete','ClientInfoController@clientInfoDelete');   //业主概况删除 废弃
//        $api->get('clientinfo-count','ClientInfoController@clientInfoCount');         //业主统计
        //$api->get('clientinfo-count-new','ClientInfoController@clientInfoCountNew');  //业主统计-new 废弃




        #报告模块
        $api->post('report-add','ReportController@reportAdd');  //添加报告
        $api->get('unexamine-count','ReportController@unexamineCount');  //获取未审核公文数量
        $api->get('report-list','ReportController@reportList'); //报告列表
        $api->get('report-detail','ReportController@reportDetail'); //报告详情
        $api->get('report-detail-yw','ReportController@reportDetailYW'); //报告详情-运维
        $api->post('report-edit','ReportController@reportEdit');    //报告编辑
        $api->post('report-success','ReportController@reportSuccess');  //报告审核通过
        $api->post('receipt-add','ReportController@receiptAdd');    //回执添加
        $api->post('receipt-edit','ReportController@receiptEdit');  //回执编辑
        $api->get('report-download-record','ReportController@downloadRecord');//文件下载 记录用户
        $api->post('file-upload','ReportController@fileUpLoad');    //文件上传
        $api->post('file-upload-examine','ReportController@examineFileUpLoad');    //文件上传
        $api->get('reporttimerefresh','ReportController@reportTimeRefresh');  //检查report 状态是否超时
        $api->post('receipt-read','ReportController@receiptRead');  //回执已读
        $api->get('reportlist-examine','ReportController@reportListByExamine');  //民警审核list
        $api->post('reportexamine-edit','ReportController@reportExamineEdit');   //民警审核通过运维发布的公文
        $api->post('reportedit-byexamine','ReportController@reportEditByExamine');   //民警编辑待发布的公文

        $api->post('reportsystem-add','ReportController@reportSystemAdd'); //添加公文系统
        $api->get('reportsystem-detail','ReportController@reportSystemDetail'); //公文系统的详情
        $api->post('reportsystem-delete','ReportController@reportSystemDelete'); //公文系统的删除
        $api->post('reportsystem-edit','ReportController@reportSystemEdit'); //公文系统的编辑
        $api->get('reportsystem-web_list','ReportController@reportSystemWebList'); //系统列表

        $api->get('report-owner-detail','ReportController@reportOwnerDetail'); //业主系统的详情
        $api->get('report-web-list','ReportController@reportWebList'); //系统列表

        #暂时废弃
//        $api->post('reportgrade-add','ReportController@reportGradeAdd'); //添加等级保护
//        $api->get('reportgrade-detail','ReportController@reportGradeDetail'); //等级保护的详情
//        $api->post('reportgrade-delete','ReportController@reportGradeDelete'); //等级保护的删除
//        $api->post('reportgrade-edit','ReportController@reportGradeEdit'); //等级保护的编辑


        #账户管理
        $api->get('police-list', 'AdminController@policeList');
        $api->get('police-lists', 'AdminController@policeLists');
        $api->post('account-login', 'AdminController@adminLogin');
        $api->post('account-login-list', 'AdminController@login');
        $api->get('account-list', 'AdminController@adminList');
        $api->get('account-list-all', 'AdminController@adminListAll');
        $api->get('account-detail', 'AdminController@adminDetail');
        $api->post('account-edit', 'AdminController@adminEdit');
        $api->post('account-delete', 'AdminController@adminDelete');
        $api->post('account-add', 'AdminController@adminAdd');
        $api->post('account-change-pwd', 'AdminController@adminChangePassword');
        #业主网站管理
        $api->post('web-add', 'AdminController@webAdd');
        $api->post('web-edit', 'AdminController@webEdit');
        $api->post('web-list', 'AdminController@webList');
        $api->post('web-delete', 'AdminController@webDelete');
        #RBAC-角色
        $api->get('role-list', 'RbacController@roleList');
        $api->get('role-list-all', 'RbacController@roleListAll');
        $api->get('role-detail', 'RbacController@roleDetail');
        $api->post('role-delete', 'RbacController@roleDelete');
        $api->post('role-add', 'RbacController@roleAdd');
        $api->post('role-edit', 'RbacController@roleEdit');
        #RBAC-权限
        $api->get('permission-type', 'RbacController@permissionType');
        $api->get('permission-list', 'RbacController@permissionList');
        $api->get('permission-detail', 'RbacController@permissionDetail');
        $api->post('permission-delete', 'RbacController@permissionDelete');
        $api->post('permission-add', 'RbacController@permissionAdd');
        $api->post('permission-edit', 'RbacController@permissionEdit');
        #RBAC-用户角色权限
        $api->get('role-account-list', 'RbacController@roleAdminList');
        $api->get('role-account-detail', 'RbacController@roleAdminDetail');
        $api->post('role-account-add', 'RbacController@roleAdminAdd');
        $api->get('permission-role-list', 'RbacController@permissionRoleList');
        $api->get('permission-role-detail', 'RbacController@permissionRoleDetail');
        $api->post('permission-role-add', 'RbacController@permissionRoleAdd');
        $api->get('permission-left', 'RbacController@permissionLeft');
        #排班情况
        $api->post('week-schedule-add', 'WorkScheduleController@weekScheduleAdd');
        //$api->post('week-schedule-edit', 'WorkScheduleController@weekScheduleEdit');#废弃
        $api->post('schedule-add', 'WorkScheduleController@scheduleAdd');
        $api->post('schedule-add-single', 'WorkScheduleController@scheduleAddSingle');
        $api->post('schedule-edit', 'WorkScheduleController@scheduleEdit');
        $api->get('schedule-list', 'WorkScheduleController@scheduleList');
        $api->get('schedule-week-list', 'WorkScheduleController@scheduleWeekList');
        $api->get('schedule-detail', 'WorkScheduleController@scheduleDetail');
        $api->get('schedule-now', 'WorkScheduleController@scheduleNow');
        $api->post('schedule-delete', 'WorkScheduleController@scheduleDelete');
        #操作日志管理
        $api->get('log-list','LogController@logList');
        $api->get('log-detail','LogController@logDetail');
        #公告板块
        $api->get('notice-detail', 'NoticeController@noticeDetail');
        $api->post('notice-add', 'NoticeController@noticeAdd');
        $api->get('notice-list', 'NoticeController@noticeList');
        $api->get('notice-new', 'NoticeController@noticeNew');
        $api->post('notice-delete', 'NoticeController@noticeDelete');
        $api->post('notice-edit', 'NoticeController@noticeEdit');
        #待办事务
        $api->get('report-affairall','UnfinishedController@affairAll');         //全部事务
        $api->post('report-finish','UnfinishedController@finishReport');         //事务完成接口
        $api->get('report-finishedall','UnfinishedController@finishedAll');     //已完成事务
        $api->get('report-unfinishedall','UnfinishedController@unfinishedAll'); //未处理代办事务--xiaofan
        $api->get('report-over','UnfinishedController@overReport'); //已处理代办事务--xiaofan
        $api->get('report-unfinishcount','UnfinishedController@unfinishReportCount'); //待办事务计数
        #登录失败记录
        $api->post('record-uncloglogin','AdminRecordController@unclogLogin');//解除登录限制
        $api->get('record-list','AdminRecordController@recordList');//所有用户最后登录时间记录列表

    });

});
