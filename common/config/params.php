<?php
return [
    'adminEmail' => 'postmaster@axoford12.cc',
    'supportEmail' => 'postmaster@axoford12.cc',
    // 用户修改密码的时间～
    'user.passwordResetTokenExpire' => 3600,
    'apiConn' => [
        // 在此处填写 api url
        // Enter Your api url here
        'url' => 'https://eg.yun.cn/api.php',

        // 在此处填写你的用户名
        // Enter your user name here
        'user' => '',

        // 在此处填写你的api key  它会在multicraft中生成
        // Enter your api key here
        // It will be generate in your multicraft
        'key' => '',

        // 在这里设置每个服务器的初始创建人数

    ],
    'IceConfig' => [
        'playerNum' => 10,

        // 原先此处的地址程序已经可以自动获得
        // 不用填写。
        // 赶快感谢作者  Axoford12 !


        // 此处为服务器的开服时间  （准备移除）
        'time' => '+1 month'
    ],
    'Fpay' => [
        // 此处是Fpay 付款的合作id 和  RSA　公钥
        // 欢迎访问  mcpe.cc具体咨询  此付款接口目前正在开发中。
        'partner' => '',

        'rsakey' => ''
    ]
];
