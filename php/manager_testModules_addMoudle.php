<?php

require_once './closed/subject.php';
$args['subjectname']=$_POST['subjectName'];
$args['subjectpassline']=$_POST['subjectpassline'];
$m=new subject();
$subjectid=$m->addSubject($args);
echo json_encode(array('result'=>'success','subjectid'=>$subjectid));
//{"result":"success","subjectid":"1"}
?>
