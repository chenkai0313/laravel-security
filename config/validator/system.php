<?php
/**
 * Created by PhpStorm.
 * User: 曹晗
 * Date: 2017/7/29
 * Time: 14:07
 */
return [
    #站内信
    'inmail' => [
        'inmail-val' => [
            'inmail_content' => '站内信内容',
            'sender_id' => '发件人id',
            'receiver_id' => '收件人id',
            'status'=>'状态',
            'inmail_title'=>'主题',
        ],
        'inmail-key' => [
            'integer' => ':attribute必须为整数',
            'required' => ':attribute必填',
            'regex' => ':attribute格式不正确',
            'unique' => ':attribute已被注册',
        ],
        #发送站内信
        'inmail-add' => [
            'inmail_content' => 'required',
            'sender_id'=>'integer|required',
            'receiver_id'=>'integer|required',
            'status'=>'integer|required',
            'inmail_title'=>'required',
        ]
    ],

    'report' => [
        'report-val' => [
            'report_name' => '公文名称',
            'report_title' => '公文标题',
            'to_admin_id' => '公文接收人',
            'police_id' => '指派民警',
            'scan_times'=>'扫描次数',
            'deal_time'=>'建议完成时间',
            'risk_level'=>'风险等级',
        ],
        'report-key' => [
            'integer' => ':attribute必须为整数',
            'required' => ':attribute必填',
            'regex' => ':attribute格式不正确',
            'unique' => ':attribute已被注册',
        ],
        #添加公文
        'report-add' => [
            'report_name' => 'required',
            'report_title'=>'required',
            'to_admin_id'=>'required',
            'police_id'=>'required',
//            'scan_times' => 'required',
//            'deal_time' => 'required',
//            'risk_level' => 'required',
        ]
    ]


];