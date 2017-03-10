<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:47
 */
error_reporting(0);
require_once './closed/subject.php';
require_once './closed/session.php';
require_once './closed/user.php';

$m = new subject();
$u = new user();
$s = new Session();
$session = $s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=2)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $subjects = $m->getActiveSubject();
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'result'=>$subjects));
}
?>
