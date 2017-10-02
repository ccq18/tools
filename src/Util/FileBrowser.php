<?php
/**
 * Created by PhpStorm.
 * User: liurongdong
 * Date: 2016/10/8
 * Time: 10:47
 */

namespace Util;

class FileBrowser
{

    /** 遍历目录
     * @param $directory
     * @param $callback callable 回调函数处理 接收2个参数(string $file, bool $is_file,string $file_type)
     * @param bool $recursive 是否递归子目录
     */
    function browser($directory, $callback,$recursive = true)
    {
        if(is_array($directory)){
            foreach ($directory as $d){
                $this->browser($d, $callback);
            }
            return;
        }
        $mydir = dir($directory);
        while ($file = $mydir->read()) {
            $filepath = "$directory/$file";
            if (($file == ".") || ($file == "..")){
            }else if (is_dir($filepath)) {
                $callback($filepath, false, '');
                if($recursive){
                    $this->browser($filepath, $callback);
                }
            } else {
                $arr = explode('.', $file);
                $ext = end($arr);
                $callback($filepath, true, $ext);
            }
        }
        $mydir->close();
    }

    /** 删除目录
     * @param string $dir
     * @return bool
     */
    public function deldir($dir) {
        //先删除目录下的文件：
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    $this->deldir($fullpath);
                }
            }
        }
        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }

}