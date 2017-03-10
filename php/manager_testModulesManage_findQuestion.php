<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/13
 * Time: 2:26
 */
error_reporting(0);
    require_once 'closed/question.php';
    $word = $_POST['word'];
    $subjectid = $_POST['subjectid'];
    $q = new question();
    $list = $q->getQuestionInfoListByWord($word,$subjectid);
    echo json_encode($list);
?>