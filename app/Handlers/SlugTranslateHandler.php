<?php
namespace App\Handler;
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */
use GuzzleHttp\Client;//请求插件客户端
use Illuminate\Support\Str;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    public function translate($text) {

        //实例化客户端
        $client = new Client();

        //初始化配置信息
        $api = '';//百度翻译api
        $appid = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        //如果没有配置百度翻译,直接采用拼音
        if(empty($appid) || empty($key)){
            return $this->pinyin($text);
        }

        //根据文档生成签名sign
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $sign = md5($appid. $text . $salt . $key);

        // 构建请求参数
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // 发送 HTTP Get 请求
        $response = $client->get($api.$query);

        $result = json_decode($response->getBody(), true);//json转关联数组
        /**
        获取结果，如果请求成功，dd($result) 结果如下：

        array:3 [
            "from" => "zh"
            "to" => "en"
            "trans_result" => array:1 [▼
                0 => array:2 [▼
                    "src" => "XSS 安全漏洞"
                    "dst" => "XSS security vulnerability"
                ]
            ]
        ]
         **/

        //查看是否有结果
        if(isset($result['trans_result'][0]['dst'])){
            $text = $result['trans_result'][0]['dst'];
            return Str::slug($text);
        }else{
            //如果没有翻译结果
            //调用备用的拼音
            return $this->pinyin($text);
        }
    }

    /**
     * 备选拼音翻译
     * @param $text
     *
     * @return string
     */
    public function pinyin($text) {

        $pinyin = new Pinyin(); // 实例化插件
        return \Str::slug($pinyin->permalink($text));//str->slug用于生成友好的url
    }
}
