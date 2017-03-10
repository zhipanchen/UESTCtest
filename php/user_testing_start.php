<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:57
 */

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
if(!$session){
    echo json_encode(array('result'=>'redirection'));
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $totleScore = $sub->getTotleScore($subjectid);
    $passScore = $sub->getPassScoreById($subjectid);
    $quesionlist = $q->getQuestionListBySubject($subjectid);
    $subject = $sub->getSubjectById($subjectid);
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'subjectname'=>$subject['subjectname'],'totleScore'=>$totleScore,'passScore'=>$passScore,'questionlist'=>$quesionlist));
}
//{"username":"peadmin","photo":"123","subjectname":"\u8bed\u6587","totleScore":5,"passScore":3,"questionlist":{"data":[{"questionid":"1","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"A","questionscore":"1"},{"questionid":"2","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"B","questionscore":"1"},{"questionid":"3","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},{"questionid":"4","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"D","questionscore":"1"},{"questionid":"5","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"bc","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"}],"number":5}}
?>