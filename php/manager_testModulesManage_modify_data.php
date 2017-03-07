<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午6:30
 */

error_reporting(0);

//$args = json_decode($_POST['args']);

$questionid=$_POST['questionid'];
$args['subjectid']=$_POST['subjectid'];
$args['questioninfo']=$_POST['questioninfo'];
$args['questionchoicea']=$_POST['questionchoicea'];
$args['questionchoiceb']=$_POST['questionchoiceb'];
$args['questionchoicec']=$_POST['questionchoicec'];
$args['questionchoiced']=$_POST['questionchoiced'];
//$args['questioncorrectanswer']='A';
$args['questionnote']=$_POST['questionnote'];
$args['questionscore']=$_POST['questionscore'];

if($_POST['A']=="on"){
    $args['questioncorrectanswer']='A';
};
if($_POST['B']=="on"){
    $args['questioncorrectanswer']='B';
};
if($_POST['C']=="on"){
    $args['questioncorrectanswer']='C';
};
if($_POST['D']=="on"){
    $args['questioncorrectanswer']='D';
};

$ques = $_FILES['question'];
$a = $_FILES['a'];
$b = $_FILES['b'];
$c = $_FILES['c'];
$d = $_FILES['d'];
$note = $_FILES['note'];
require_once './closed/dir.php';
$di = new dir();
$di->makeDirInFilesData("files");
$di->makeDirInFilesData("files/question");
$di->makeDirInFilesData("files/question/".$args['subjectid']);
$di->makeDirInFilesData("files/question/".$args['subjectid'].'/'.$questionid);
$questionpicture = "files/question/".$args['subjectid']."/".$questionid."/question.jpg";
$questionpicturea = "files/question/".$args['subjectid']."/".$questionid."/a.jpg";
$questionpictureb = "files/question/".$args['subjectid']."/".$questionid."/b.jpg";
$questionpicturec = "files/question/".$args['subjectid']."/".$questionid."/c.jpg";
$questionpictured = "files/question/".$args['subjectid']."/".$questionid."/d.jpg";
$questionnotepicture = "files/question/".$args['subjectid']."/".$questionid."/note.jpg";
require_once './closed/question.php';
$que = new question();
if($ques) {
    move_uploaded_file($ques['tmp_name'], $questionpicture);
    $que->modQuestionById(array('questionpicture'=>$questionpicture),$questionid);
}
if($a) {
    move_uploaded_file($a['tmp_name'], $questionpicturea);
    $que->modQuestionById(array('questionpicturea'=>$questionpicturea),$questionid);
}
if($b) {
    move_uploaded_file($b['tmp_name'], $questionpictureb);
    $que->modQuestionById(array('questionpictureb'=>$questionpictureb),$questionid);
}
if($c) {
    move_uploaded_file($c['tmp_name'], $questionpicturec);
    $que->modQuestionById(array('questionpicturec'=>$questionpicturec),$questionid);
}
if($d) {
    move_uploaded_file($d['tmp_name'], $questionpictured);
    $que->modQuestionById(array('questionpictured'=>$questionpictured),$questionid);
}
if($note) {
    move_uploaded_file($note['tmp_name'], $questionnotepicture);
    $que->modQuestionById(array('questionnotepicture'=>$questionnotepicture),$questionid);
}
if($args['questioninfo'])
{
    $arg['questioninfo']=$args['questioninfo'];
    $que->modQuestionById($arg,$questionid);
}
if($args['questionchoicea'])
{
    $arg['questionchoicea']=$args['questionchoicea'];
    $que->modQuestionById($arg,$questionid);
}
if($args['questionchoiceb'])
{
    $arg['questionchoiceb']=$args['questionchoiceb'];
    $que->modQuestionById($arg,$questionid);
}
if($args['questionchoicec'])
{
    $arg['questionchoicec']=$args['questionchoicec'];
    $que->modQuestionById($arg,$questionid);
}
if($args['questionchoiced'])
{
    $arg['questionchoiced']=$args['questionchoiced'];
    $que->modQuestionById($arg,$questionid);
}
if($args['questionnote'])
{
    $arg['questionnote']=$args['questionnote'];
    $que->modQuestionById($arg,$questionid);
}
if($args['questioncorrectanswer'])
{
    $arg['questioncorrectanswer']=$args['questioncorrectanswer'];
    $que->modQuestionById($arg,$questionid);
}
if($args['subjectid'])
{
    $ques->modQuestionSubjectIdById($args['subjectid'],$questionid);
}
if($args['questionscore'])
{
    $ques->modQuestionScoreById($args['questionscore'],$questionid);
}
$ques->modQuestionById($args,$questionid);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>
