<?php
error_reporting(0);
require_once './closed/question.php';
require_once './closed/session.php';
require_once './closed/user.php';
require_once './closed/config.php';
require_once './closed/subject.php';

$subjectid=$_POST['subjectId'];
$page=$_POST['subjectPage'];

$page=$page>0?$page:1;
$d=new question();
$s=new Session();
$u=new user();
$session=$s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=1)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else {
    $result = $d->getQuestionListsBySubjectId($subjectid, $page, PN);
    $res = array();
    $m = new subject();
    $subject = $m->getSubjectById($subjectid);
    $res['subjectName'] = $subject['subjectname'];
    $res['totlePage'] = $result['page'];
    $res['questionNumber'] = $result['number'];
    $res['questionData'] = $result['data'];
    $user = $u->getUserById($session['sessionuserid']);
    echo json_encode(array('username' => $user['username'], 'photo' => $user['photo'], 'res' => $res));
}
?>

