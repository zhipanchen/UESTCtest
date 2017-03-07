<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午6:06
 */

//$args = json_decode($_POST['args']);

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
require_once './closed/question.php';
$questiona = new question();
$questionid = $questiona->addQuestion($args);
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
move_uploaded_file($ques['tmp_name'],$questionpicture);
move_uploaded_file($a['tmp_name'],$questionpicturea);
move_uploaded_file($b['tmp_name'],$questionpictureb);
move_uploaded_file($c['tmp_name'],$questionpicturec);
move_uploaded_file($d['tmp_name'],$questionpictured);
move_uploaded_file($note['tmp_name'],$questionnotepicture);
$arg=array();
if($ques)
{
    $arg['questionpicture'] = $questionpicture;
}
if($a)
{
    $arg['questionpicturea'] = $questionpicturea;
}
if($b)
{
    $arg['questionpictureb'] = $questionpictureb;
}
if($c)
{
    $arg['questionpicturec'] = $questionpicturec;
}
if($d)
{
    $arg['questionpictured'] = $questionpictured;
}
if($note)
{
    $arg['questionnotepicture'] = $questionnotepicture;
}
$questiona->modQuestionById($arg,$questionid);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>
