<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午10:04
 */
error_reporting(0);
require_once './closed/session.php';
require_once './closed/user.php';
require_once './closed/subject.php';
require_once './closed/history.php';

$subjectid = $_POST['subjectid'];
$questions = $_POST['questions'];
$historyusetime = $_POST['historyusetime'];

$u = new user();
$s = new Session();
$h = new history();
$sub = new subject();

$session = $s->getCurrentSession();

if(!$session){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $args['userid']=$user['userid'];
    $args['subjectid']=$subjectid;
    $args['questions']=$questions;
    $args['historyusetime']=$historyusetime;
    $historyid = $h->addHistory($args);
    $history = $h->getHistoryById($historyid);
    $score = $history['historyscore'];
    $passScore = $sub->getPassScoreById($subjectid);
    $isPass=0;
    if($score>$passScore)
    {
        $isPass=1;
    }
    echo json_encode(array('username'=>$user['username'],'score'=>$score,'isPass'=>$isPass));
}
?>