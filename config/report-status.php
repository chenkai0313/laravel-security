<?php
/**
 * 公文 status 配置表
 * 防止在代码里写死 1，2，3，4这种
 * User: caohan
 * Date: 2017/11/13
 */

return [
    //状态表
    'status' => [
        'send_rectify' => 0,            //0整改发送
        'on_rectify' => 1,              //1整改中
        'receipt_rectify' => 2,         //2整改回执
        'send_rectify_again' => 3,      //3再次整改发送
        'audit_pass' => 4,              //4审核通过
        'overtime' => 5,                //5已超时
        'receipt_rectify_again' => 6,   //6再次整改回执
    ],
    'is_examine' => [
          'not_passed '=>0,             //0未通过
          'passed'=>1,                  //1通过
          'refuse'=>2,                  //2拒绝
    ],
];