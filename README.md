# php-composer-wx-login

## tp5 config配置 wx.php
````php
// +----------------------------------------------------------------------
// | 微信设置
// +----------------------------------------------------------------------
return [
    'app_id' => 'wxxxxxxxxxxxxxxx77e',
    'secret' => '242eaxxxxxxxxxxxxxxxxxxxxxx5e1bed55',
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?".
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code"
];


````
