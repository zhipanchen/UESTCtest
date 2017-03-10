<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午4:56
 */
error_reporting(0);
    $subjectid=$_POST['subjectid'];
    $subjectpassline=$_POST['subjectPassLine'];
    require_once './closed/subject.php';
    $s = new subject();
    if((is_numeric($subjectpassline)) && ($subjectpassline>0) && ($subjectpassline<100))
    {
        $s->modSubjectPassLine($subjectid,$subjectpassline);
        echo json_encode(array('result'=>'success'));
    }
    else
    {
        echo json_encode(array('result'=>'fail'));
    }
?>