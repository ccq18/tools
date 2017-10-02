<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2016/1/12
 * Time: 12:09
 */

namespace Util;


class Tpl
{
    /**
     * @param $text
     * @param array $data
     * @return mixed
     */
    public static function parse($text, $data = [])
    {

        $text = str_replace(array('<?', '?>', '{{', '}}', '{%', '%}'), array('&lt;?', '?&gt;', '<?php echo ', '; ?>', '<?php ', '; ?>'), $text);
        $file = storage_path('framework/cache/'.md5($text).'.php');//buf2
        file_put_contents($file,$text);
        $text = static::parsePhp($file, $data);
        return str_replace(array('&lt;?', '?&gt;'), array('<?', '?>'), $text);
    }

    /**
     * @param $file
     * @param array $data
     * @return mixed
     */
    public static function parsePhp($file, $data = [])
    {
        extract($data);
        ob_start();
        require $file;
//        eval('? >' . $text);
        $text = ob_get_contents();
        ob_end_clean();
        return $text;
    }
}