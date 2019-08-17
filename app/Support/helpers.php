<?php



if (!function_exists('user')) {
    /**
     * @param null $driver
     * @return \App\Model\User
     */
    function user($driver = null)
    {
        if ($driver) {
            return app('auth')->guard($driver)->user();
        }

        return app('auth')->user();
    }
}

if (!function_exists('flash')) {

    function flash($title, $message)
    {
        session()->flash('flash_message', [
            // 'type'    => $type,
            'title'   => $title,
            'message' => $message
        ]);
    }

}
if (!function_exists('generate_path')) {

    function generate_path($base, $path)
    {
        return rtrim($base, '\/') . '/' . ltrim($path, '\/');
    }

}


if (!function_exists('str_translate')) {

    function str_translate($key, $diver = 'str_translate_diver_jinshan')
    {
        static $qs = null;
        // $diver = 'str_translate_diver_jinshan';//str_translate_diver_youdao  str_translate_diver_jinshan_detail
        if (empty($qs)) {
            $qs = \Cache::get($diver, []);
        }

//    API key：394865828
//keyfrom：codefanyi2
//    数据接口
//http://fanyi.youdao.com/openapi.do?keyfrom=codefanyi2&key=394865828&type=data&doctype=<doctype>&version=1.1&q=要翻译的文本
//版本：1.1，请求方式：get，编码方式：utf-8
//主要功能：中英互译，同时获得有道翻译结果和有道词典结果（可能没有）
//参数说明：
//　type - 返回结果的类型，固定为data
//　doctype - 返回结果的数据格式，xml或json或jsonp
//　version - 版本，当前最新版本为1.1
//　q - 要翻译的文本，必须是UTF-8编码，字符长度不能超过200个字符，需要进行urlencode编码
//　only - 可选参数，dict表示只获取词典数据，translate表示只获取翻译数据，默认为都获取
//　注： 词典结果只支持中英互译，翻译结果支持英日韩法俄西到中文的翻译以及中文到英语的翻译
//errorCode：
//　0 - 正常
//　20 - 要翻译的文本过长
//　30 - 无法进行有效的翻译
//　40 - 不支持的语言类型
//　50 - 无效的key
//　60 - 无词典结果，仅在获取词典结果生效

        if (!isset($qs[$key])) {
            $qs[$key] = $diver($key);
            \Cache::forever($diver, $qs);
        }

        return $qs[$key];

    }

    function str_translate_diver_youdao($key)
    {
        static $http = null;
        if (empty($http)) {
            $http = new \Ido\Tools\Util\Http();
        }

        return $http->getJson("http://fanyi.youdao.com/openapi.do", [
            'keyfrom' => 'codefanyi2',
            'key'     => '394865828',
            'type'    => 'data',
            'doctype' => 'json',
            'version' => '1.1',
            'q'       => $key,
        ]);
    }

    function str_translate_diver_jinshan($key)
    {
        static $http = null;
        if (empty($http)) {
            $http = new \Ido\Tools\Util\Http();
        }

        return $http->get("http://dict-co.iciba.com/api/dictionary.php", [
            'key'  => '6741D17CDADF4293923EC7D0583E9463',
            'type' => 'json',
            'w'    => $key,
        ]);
    }

    function str_translate_diver_jinshan_detail($key)
    {
        static $http = null;
        if (empty($http)) {
            $http = new \Ido\Tools\Util\Http();
        }

        $str = $http->get("http://dict-co.iciba.com/api/dictionary.php", [
            'key' => '6741D17CDADF4293923EC7D0583E9463',
            'w'   => $key,
        ]);

        return xml_to_array($str);
    }
    //http://dict-co.iciba.com/api/dictionary.php?w=go&key=6741D17CDADF4293923EC7D0583E9463&type=json
}


if (!function_exists('build_url')) {
    function build_url($path, $parameters = [])
    {

        $output = get_url_params($path);
        $parm_str = http_build_query(array_merge($output, $parameters));

        return url(ltrim(clear_urlcan($path), '\/') . (empty($parm_str) ? "" : '?' . $parm_str));
    }
}
if (!function_exists('get_url_params')) {
    function get_url_params($path)
    {
        $info = parse_url($path);
        $params = isset($info['query']) ? $info['query'] : "";
        parse_str($params, $output);

        return $output;
    }
}
if (!function_exists('clear_urlcan')) {
    function clear_urlcan($url)
    {
        if (strpos($url, '?') !== false) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        return $url;
    }
}

if (!function_exists('is_production')) {
    function is_production()
    {
        return env('APP_ENV') == 'production';
    }
}

/**
 * xml转化为数组
 * @param  [type] $xml [description]
 * <xml>
 *     <appid><![CDATA[wx495813085bb41c7a]]></appid>
 *     <attach><![CDATA[4757,10]]></attach>
 * </xml>
 * @return [type]      [description]
 *Array
 * (
 * [0] => Array
 * (
 * [tag] => APPID
 * [attributes] =>
 * [val] => wx495813085bb41c7a
 * [level] => 2
 * )
 *
 * [1] => Array
 * (
 * [tag] => ATTACH
 * [attributes] =>
 * [val] => 4757,10
 * [level] => 2
 * )
 * )
 *
 */
function xml_to_array($xml)
{

    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    return $values;

}

function rdata($name)
{
    $rs = file_get_contents(storage_path($name));

    return json_decode($rs, true);
}

function wdata($name, $content)
{
    return file_put_contents(storage_path($name), json_encode($content));
}

function json_response($data, $message = 'success', $code = 200)
{
    return response()->json(['data' => $data, 'message' => $message, 'code' => $code], 200);
}
function login_url(){
    return resolve(Ido\Tools\SsoAuth\AuthHelper::class)->getLoginUrl();
}

function logout_url(){
    return url('/logout');
}
function register_url(){
    return resolve(Ido\Tools\SsoAuth\AuthHelper::class)->getRegisterUrl();
}