# php-composer-wx-login

## tp+laravel config配置 wx.php
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


````

1.通过code获取openid：

Array ( 
    [open_id] => objb**************GPoUjJwcy04 
    [app_id] => wx5dc******009b1 
    [secret] => 2b6b170********d902456fd9e3 
    [session_key] => Lzh*******mQoq4eMyw== 
)


````

````php
    //  入口，通过code获取open_id等[laravel6+tp5]
    public function getToken($paramArray = [])
    {
        $code = !empty($paramArray['code'])?$paramArray['code']:'';

        if ($code) {
            $weChatService = new WeChatService();
            $WxData = $weChatService->getDataByCode($code);

            $open_id = $WxData['open_id'];
            $session_key = $WxData['session_key'];                
            print_r($WxData);exit;
        }
        return;
    }

        /**
         * @param $code
         * @return array
         * @throws ParamException
         * @author:  deng    (2020-03-28 19:24)
         */
        public function getDataByCode($code)
        {
            $weChatConfig = Config::get('wechat');
    
            $app_id = $weChatConfig['app_id'];
            $secret = $weChatConfig['secret'];
            $login_url = $weChatConfig['login_url'];
    
            $paramArray = [
                'app_id' => $app_id,
                'secret' => $secret,
                'login_url' => $login_url
            ];
    
            $wxLogin = new WeChat($paramArray, $code);
            $wxResult = $wxLogin->get();
    
            if (empty($wxResult)) {
                // 为什么以empty判断是否错误，这是根据微信返回
                // 这种情况通常是由于传入不合法的code
                throw new ParamException('获取session_key及openid异常，微信内部错误');
            }
    
            // 建议用明确的变量来表示是否成功
            // 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
            // 这样非常不好判断，只能使用errcode是否存在来判断
            $loginFail = array_key_exists('errcode',$wxResult);
    
            if ($loginFail) {
                throw new ParamException($wxResult['errmsg']);
            }
    
            return [
                'open_id' => $wxResult['openid'],
                'app_id' => $app_id,
                'secret' => $secret,
                'session_key' => $wxResult['session_key']
            ];
        }

````


````php
=stdClass Object ( 
[phoneNumber] => 1507xxxx357,
[purePhoneNumber] => 1507xxxx357,
[countryCode] => 86 ,
[watermark] => stdClass 
    Object ( 
        [timestamp] => 1585xxxx828 
        [appid] => wx5d60xxxx635009b1 
    ) 
)
````
