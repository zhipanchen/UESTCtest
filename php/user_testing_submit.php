<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午10:04
 */

require_once './closed/session.php';
require_once './closed/user.php';
require_once './closed/subject.php';
require_once './closed/history.php';

$subjectid = $_POST['subjectid'];
$questions = $_POST['questions'];
$historyusetime = $_POST['historyusetime'];

//$subjectid=1;
//$temp=array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'A');
//$questions=json_encode($temp);
//$historyusetime=123;

$u = new user();
$s = new Session();
$h = new history();
$sub = new subject();

$session = $s->getCurrentSession();

if(!$session){
    echo json_encode(array('result'=>'redirection'));
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
//{"username":"peadmin","score":"4","isPass":1}
?>