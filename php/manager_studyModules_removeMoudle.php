<?php
error_reporting(0);
    require_once './closed/module.php';
    $moduleid=$_POST['moduleId'];
    $M=new module();
    $M->delModuleById($moduleid);
    echo json_encode(array('result'=>'success'));
?>