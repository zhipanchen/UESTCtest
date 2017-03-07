<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午4:56
 */
    $subjectid=$_POST['subjectid'];
    $subjectpassline=$_POST['subjectPassLine'];
    require_once './closed/subject.php';
    $s = new subject();
    $s->modSubjectPassLine($subjectid,$subjectpassline);
    echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>