<?php

require_once './closed/module.php';

$moduleId=$_POST['moduleId'];
$useValue=$_POST['use'];

$m=new module();
$m->modModuleState($moduleId,$useValue);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>