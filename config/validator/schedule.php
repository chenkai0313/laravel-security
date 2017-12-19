<?php
/**
 * 值班
 * Author: 叶帆
 * Date: 2017/10/31
 */
return [
    #排班数据验证
    'work_schedule' => [
        'week-val' => [
            'schedule_date' => '排班初始化时间',
        ],
        'week-key' => [
            'required' => ':attribute必填',
        ],
        'week-add' => [
            'schedule_date' => 'required',
        ]
    ],

];