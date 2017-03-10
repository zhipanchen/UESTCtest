<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:10
 */
error_reporting(0);
require_once './closed/history.php';
require_once './closed/user.php';

$userid=$_POST['userid'];

$h = new history();
$u = new user();

$user = $u->getUserById($userid);
$list = $h->getHistoryListByUserId($userid);
echo json_encode(array('username' => $user['username'], 'photo' => $user['photo'], 'list' => $list));
?>
