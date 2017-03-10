<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午8:55
 */
error_reporting(0);
    $userid = $_POST['userid'];
    $usergroupid = $_POST['usergroupid'];

    require_once './closed/user.php';
    $u = new user();
    if($userid!=1)
    {
        $u->modUserGroupById($userid,$usergroupid);
        echo json_encode(array('result'=>'success'));
    }
    else
    {
        echo json_encode(array('result'=>'fail'));
    }
?>