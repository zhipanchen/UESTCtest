<?php
error_reporting(0);
require_once './closed/module.php';

$moduleId=$_POST['moduleId'];
$useValue=$_POST['use'];

$m=new module();
$m->modModuleState($moduleId,$useValue);
echo json_encode(array('result'=>'success'));
?>