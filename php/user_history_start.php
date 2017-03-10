<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:10
 */
error_reporting(0);
require_once './closed/history.php';
require_once './closed/session.php';
require_once './closed/user.php';

$h = new history();
$s = new Session();
$u = new user();

$session = $s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=2)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $list = $h->getHistoryListByUserId($session['sessionuserid']);
    echo json_encode(array('username' => $user['username'], 'photo' => $user['photo'], 'list' => $list));
}
?>
