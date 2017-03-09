<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
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
        // 此处的填写应该不带/
        // 不要填成   https://ficecraft.dev/
        // 上面不要填写最后的  /
        // 格式应该为  http:// 或  https://
        // + 你的域名
        // 可以带上端口 如  http://ficecraft.dev:88

        'webRoot' => 'http://icecraft.axoford12.cn:88',
        'time' => '+1 month'
    ],
    'Fpay' => [
        // 此处是Fpay 付款的合作id 和  RSA　公钥
        // 欢迎访问  mcpe.cc具体咨询  此付款接口目前正在开发中。
        'partner' => '',
        'rsakey' => ''
    ]
];
