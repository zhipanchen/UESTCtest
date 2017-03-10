<?php
error_reporting(0);
require_once './closed/subject.php';

$subjectId=$_POST['subjectId'];

$M=new subject();
$subjectState=$M->getSubjectStateById($subjectId);
echo json_encode(array('result'=>$subjectState));
?>
