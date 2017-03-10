<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/13
 * Time: 15:40
 */
error_reporting(0);
    require_once './closed/user.php';
    $userid = $_POST['userid'];
    $u = new user();
    $user = $u->getUserById($userid);
    $path = 'photo/'.md5($userid).'.jpg';
    unlink($path);
    $u->modUserById(array('photo'=>""),$userid);
    echo json_encode(array('result'=>'success'));

?>
