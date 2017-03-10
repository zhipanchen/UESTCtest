<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:57
 */
error_reporting(0);
require_once './closed/session.php';
require_once './closed/user.php';
require_once './closed/question.php';
require_once './closed/subject.php';

$subjectid = $_POST['subjectid'];

$u = new user();
$s = new Session();
$sub = new subject();
$q = new question();

$session = $s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=2)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $totleScore = $sub->getTotleScore($subjectid);
    $passScore = $sub->getPassScoreById($subjectid);
    $quesionlist = $q->getQuestionListBySubject($subjectid);
    $subject = $sub->getSubjectById($subjectid);
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'subjectname'=>$subject['subjectname'],'totleScore'=>$totleScore,'passScore'=>$passScore,'questionlist'=>$quesionlist));
}
?>