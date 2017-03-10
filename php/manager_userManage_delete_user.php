<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午8:46
 */
error_reporting(0);
require_once './closed/user.php';
$userid = $_POST['userid'];
$u = new user();
$u->delUserByUserId($userid);
echo json_encode(array('result'=>'success'));
?>
