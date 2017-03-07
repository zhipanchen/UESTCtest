<?php
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
if(!$session){
    echo json_encode(array('result'=>'redirection'));
}else{
    $result=$d->getQuestionListsBySubjectId($subjectid,$page,PN);
    $res=array();
    $m = new subject();
    $subject = $m->getSubjectById($subjectid);
    $res['subjectName']=$subject['subjectname'];
    $res['totlePage']=$result['page'];
    $res['questionNumber']=$result['number'];
    $res['questionData']=$result['data'];
    $user=$u->getUserById($session['sessionuserid']);
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'res'=>$res));
//    {"username":"peadmin","photo":"123","res":{"subjectName":"\u8bed\u6587","totlePage":1,"questionNumber":5,"questionData":[{"questionid":"1","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"A","questionscore":"1"},{"questionid":"2","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"B","questionscore":"1"},{"questionid":"3","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},{"questionid":"4","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"D","questionscore":"1"},{"questionid":"5","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"bc","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"}]}}
};
?>

