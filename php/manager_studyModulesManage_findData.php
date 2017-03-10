<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/13
 * Time: 1:53
 */
error_reporting(0);
    require_once 'closed/data.php';
    $word = $_POST['word'];
    $moduleid=$_POST['moduleid'];
    $d = new data();
    $list = $d->getDataInfoListByWord($word,$moduleid);
    echo json_encode($list);
?>