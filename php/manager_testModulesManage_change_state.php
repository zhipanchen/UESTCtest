<?php

require_once './closed/subject.php';

$subjectId=$_POST['subjectId'];
$useValue=$_POST['use'];

$m=new subject();
$m->modSubjectState($subjectId,$useValue);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>
