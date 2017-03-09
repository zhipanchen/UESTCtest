<?php

require_once './closed/module.php';

    $moduleid=$_POST['moduleId'];
//    $moduleid=3;
    $M=new module();
    $M->delModuleById($moduleid);
    echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>