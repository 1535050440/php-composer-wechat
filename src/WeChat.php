<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2020/03/28
 * Time: 10:01
 */
namespace DengPhp;

/**
 * Class WxChat
 * @package DengPhp
 */
class WeChat
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    /**
     * 构造方法
     * @param $paramArray
     * @param $code
     */
    public function __construct($paramArray,$code)
    {
        $this->code = $code;
        $this->wxAppID = $paramArray['app_id'];
        $this->wxAppSecret = $paramArray['secret'];

        //  拼接url拼接访问微信接口
        $this->wxLoginUrl = sprintf($paramArray['login_url'],
            $this->wxAppID ,
            $this->wxAppSecret ,
            $this->code
        );
    }

    /**
     * 获取   openid  +   session_key
     * @return mixed
     */
    public function get()
    {
        //  发送get请求(字符串)
        $result = $this->curlGet($this->wxLoginUrl);
        $wxResult = json_decode($result, true);

        return $wxResult;
    }

    /**
     * 发送网络请求
     * @param $url
     * @param int $httpCode
     * @return bool|string
     */
    public function curlGet($url, &$httpCode = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        //  不做证书效验，部署在Linux环境下请改为true
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 10);
        $file_contents = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $file_contents;
    }


}
