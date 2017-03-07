<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/1
 * Time: 1:52
 */
class dir
{
    public function makeDirInFilesData($dirnameinfo)
    {
        if (!is_dir($dirnameinfo.'/'))
        {
            mkdir($dirnameinfo.'/');
        }
    }

    public function delDir($dir)
    {
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