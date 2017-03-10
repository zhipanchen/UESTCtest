<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:15
 */
error_reporting(0);
$historytime=$_POST['historytime'];
require_once './closed/history.php';
require_once './closed/session.php';
require_once './closed/subject.php';

$h = new history();
$s = new Session();
$sub = new subject();

$session = $s->getCurrentSession();
$history = $h->getHistoryByUserIdByHistoryTime($session['sessionuserid'],$historytime);
$subject = $sub->getSubjectById($history['subjectid']);
echo json_encode(array('result'=>$history,'subjectname'=>$subject['subjectname']));
?>