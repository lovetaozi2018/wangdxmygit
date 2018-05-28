<?php
namespace App\Helpers;
use Doctrine\Common\Util\Debug;
use Illuminate\Support\Facades\Log;

trait WechatHelper {
    
    public function getUserAvatar($openid) {
        $token = $this->getAccessToken(self::URL_GET_ACCESSTOKEN, env('APP_ID'), env('APP_SECRET'));
        $result = json_decode($token);
        $accessToken = $result->access_token;
        Log::debug($accessToken);
        $userInfo = $this->getUserInfo(self::URL_GET_USER, $accessToken, $openid);
        Log::debug(json_encode($userInfo));
        return json_decode($userInfo)->headimgurl;
    }
    
    /**
     *  获取access_token
     *
     * @param string $url 接口地址
     * @param string $appId
     * @param string $appSecret
     * @return bool
     */
    public function getAccessToken($url, $appId, $appSecret) {
        
        return self::curlGet(sprintf($url, $appId, $appSecret));
        
    }
    
    public function curlGet($url) {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
        
    }
    
    /**
     * Get detailed user information
     * @param $url
     * @param $token
     * @param $openid
     * @return mixed
     */
    public function getUserInfo($url, $token, $openid) {
        return self::curlGet(sprintf($url, $token, $openid));
        
    }
    
    public function curlPost($url, $post = '') {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
        
    }
}