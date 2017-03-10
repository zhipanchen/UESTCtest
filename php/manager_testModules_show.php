<?php
error_reporting(0);
require_once './closed/session.php';
require_once './closed/subject.php';
require_once './closed/user.php';

$S=new Session();
$u=new user();
$session=$S->getCurrentSession();
if(!$session||($session['sessiongroupid']!=1)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $username = $session['sessionusername'];
    $m = new subject();
    $subject = $m->getSubjectList();
    echo json_encode(array('username' => $user['username'], 'photo' => $user['photo'], 'list' => $subject));
}
?>