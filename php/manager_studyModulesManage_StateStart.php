<?php
error_reporting(0);
require_once './closed/module.php';

$moduleId=$_POST['moduleId'];

$m=new module();
$moduleState=$m->getModuleStateById($moduleId);
echo json_encode(array('result'=>$moduleState));
?>