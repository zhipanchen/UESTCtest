<?php

require_once './closed/subject.php';

$subjectid=$_POST['subjectId'];
$M=new subject();
$M->delSubjectById($subjectid);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>
