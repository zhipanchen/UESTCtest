<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/18
 * Time: 15:50
 */
error_reporting(0);
$questionid = $_POST['questionid'];
require_once 'closed/question.php';
$q = new question();
$question = $q->getQuestionById($questionid);
echo json_encode($question);
?>