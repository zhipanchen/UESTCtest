<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/30
 * Time: 22:53
 */

require_once 'config.php';

function connectDb()
{
    try{
        $pdo =new PDO("mysql:host=".DH.";dbname=".DB.";charset=utf8",DU,DP);
    }catch (PDOException $e)
    {
        die("数据库连接失败".$e->getMessage());
    }
    return $pdo;
}
?>