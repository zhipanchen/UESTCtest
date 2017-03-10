<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/13
 * Time: 15:10
 */
require_once './closed/question.php';

$questionid = $_POST['questionid'];
$func = $_POST['func'];
$d = new question();
$question = $d->getQuestionById($questionid);
$path = "files/question/".$question['subjectid']."/".$questionid."/".$func.".jpg";
unlink($path);
switch ($func)
{
    case 'ques':
        $d->modQuestionById(array("questionpicture"=>""),$questionid);
        break;
    case 'a':
        $d->modQuestionById(array("questionpicturea"=>""),$questionid);
        break;
    case 'b':
        $d->modQuestionById(array("questionpictureb"=>""),$questionid);
        break;
    case 'c':
        $d->modQuestionById(array("questionpicturec"=>""),$questionid);
        break;
    case 'd':
        $d->modQuestionById(array("questionpictured"=>""),$questionid);
        break;
    case 'note':
        $d->modQuestionById(array("questionnotepicture"=>""),$questionid);
        break;
}
echo json_encode(array('result'=>'success'));
?>

