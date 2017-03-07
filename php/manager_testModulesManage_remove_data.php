<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午6:26
 */

$questionid = $_POST['questionid'];
require_once './closed/question.php';
$q = new question();
$question = $q->getQuestionById($questionid);
require_once './closed/dir.php';
$d = new dir();
$d->delDir('files/question/'.$question['subjectid'].'/'.$questionid);
$q->delQuestionById($questionid);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>
