<?php
require_once './closed/subject.php';

$subjectId=$_POST['subjectId'];

$M=new subject();
$subjectState=$M->getSubjectStateById($subjectId);
echo json_encode(array('result'=>$subjectState));
//{"result":"1"}
?>
