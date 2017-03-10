<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午8:55
 */
    $userid = $_POST['userid'];
    $usergroupid = $_POST['usergroupid'];

    require_once './closed/user.php';
    $u = new user();
    $u->modUserGroupById($userid,$usergroupid);
    echo json_encode(array('result'=>'success'));
//{"result":"seccess"}
?>