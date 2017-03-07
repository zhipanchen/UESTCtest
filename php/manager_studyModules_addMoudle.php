<?php

require_once './closed/module.php';
    $args['modulename']=$_POST['moduleName'];
    $m=new module();
    $moudleid=$m->addModule($args);
    echo json_encode(array('result'=>'success','moudleId'=>$moudleid));
//{"result":"success","moudleId":"2"}
?>
