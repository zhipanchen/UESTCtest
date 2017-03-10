<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:15
 */

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
//{"result":{"historyid":"1","userid":"1","subjectid":"1","questions":"{\"2\":\"A\",\"3\":\"A\",\"4\":\"A\"}","historywrongnumber":"3","historytime":"1483890644","historyscore":"2","historyusetime":"123"},"subjectname":"\u8bed\u6587"}
?>