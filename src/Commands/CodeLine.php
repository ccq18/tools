<?php

namespace Commands;

use Illuminate\Console\Command;
use Util\FileBrowser;


class CodeLine extends Command
{
    protected $signature = 'codeinfo {path*}';

    protected $description = 'codeinfo';

    public function handle(FileBrowser $fileBrowser)
    {
        $paths = $this->argument('path');
        $infos = [];
        collect($paths)->map(function ($path) use ($fileBrowser, &$infos) {
            $info = $this->totalPathInfo($fileBrowser, $path);
            //合并多维数组
            foreach ($info as $k => $v){
                if(!isset($infos[$k])){
                    $infos[$k] = $v;
                }else{
                    foreach ($v as $kk => $vv){
                        $infos[$k][$kk] += $vv;
                    }
                }

            }

        });
        ksort($infos);
        $this->info(print_r($infos, true));
    }

    public function totalPathInfo(FileBrowser $fileBrowser, $path)
    {
        $info = [];
        $fileBrowser->browser($path, function ($file, $isFile, $fileType) use (&$info) {
            if ($isFile) {
                $fileType = $this->fileType($fileType);
                if (!isset($info[$fileType])) {
                    $info[$fileType] = ['file_size' => 0, 'file_line' => 0];
                }
                $info[$fileType]['file_size'] += filesize($file);
                $info[$fileType]['file_line'] += $this->countLine($file);
            }
        });
        $all = ['file_size' => 0, 'file_line' => 0];
        collect($info)->map(function ($v) use (&$all) {
            $all['file_size'] += $v['file_size'];
            $all['file_line'] += $v['file_line'];

        });
        $info['_all'] = $all;

        return $info;

    }

    public function fileType($fileType)
    {
        if (strlen($fileType) > 5) {
            $fileType = '_rare';
        }
        if (is_numeric($fileType)) {
            $fileType = '_numeric';
        }
        if ($fileType === '') {
            $fileType = '_no_ext';
        }
        $fileType = strtolower($fileType);

        return $fileType;
    }

    public function countLine($file)
    {
        $fp = fopen($file, "r");
        $i = 0;
        while (!feof($fp)) {
            //每次读取2M
            if ($data = fread($fp, 1024 * 1024 * 2)) {
                //计算读取到的行数
                $num = substr_count($data, "\n");
                $i += $num;
            }
        }
        fclose($fp);

        return $i;
    }

}