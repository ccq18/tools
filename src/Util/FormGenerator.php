<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2017/6/1
 * Time: 下午4:16
 */

namespace Util;


class FormGenerator
{
    public static function generateByArray($data, $path,$method = 'get', $action = '')
    {
        $path = str_replace('.','/',$path);
        $formData = [];
        foreach ($data as $k => $v) {
            $line = ['type' => 'text', 'name' => $k, 'remark' => $k, 'value' => ''];
            if (is_array($v)) {
                $name = is_numeric($k)?$v['name']:$k;
                $line['name'] = $name;
                $line['remark'] = $name;
                $line = array_merge($line, $v);
            } else {
                if (is_numeric($k)) {
                    $line['value'] = '';
                    $line['name'] = $v;
                    $line['remark'] = $v;
                } else {
                    $line['value'] = $v;
                }
            }
            $formData[] = $line;
        }
        $code = Tpl::parse(file_get_contents(__DIR__ . '/Generate/form.tpl'), [
            'formData' => $formData,
            'action' => $action,
            'method' => $method,
        ]);

        $dir = 'views/' . ltrim(dirname($path), '\/');
        if (!is_dir(resource_path($dir))) {
            mkdir(resource_path($dir),0777, true);
        }

        file_put_contents(resource_path('views/' . ltrim($path, '\/').'.blade.php'), $code);
    }

}