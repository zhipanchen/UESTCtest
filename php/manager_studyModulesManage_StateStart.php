<?php
require_once './closed/module.php';

$moduleId=$_POST['moduleId'];

$M=new module();
$moduleState=$M->getModuleStateById($moduleId);
echo json_encode(array('result'=>$moduleState));
//{"result":"1"}
?>