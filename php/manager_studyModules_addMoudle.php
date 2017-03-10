<?php
error_reporting(0);
require_once './closed/module.php';
    $args['modulename']=$_POST['moduleName'];
    $m=new module();
    $fob=array('<','>',',','.','?','/',';',':','"',"'",'[',']','{','}','|','\\','+','=','-','_','!','@','#','$','%','^','&','*','(',')','~','`');
    foreach ($fob as $f)
    {
        if(strpos($args['modulename'],$f) !== false)
        {
            echo json_encode(array('result'=>'fail'));
            exit(0);
        }
    }
    if($m->getModuleByName($args['modulename']))
    {
        echo json_encode(array('result'=>'fail'));
        exit(0);
    }
    if((strlen($args['modulename'])<=0) || (strlen($args['modulename'])>10))
    {
        echo json_encode(array('result'=>'fail'));
        exit(0);
    }
    $moudleid=$m->addModule($args);
    echo json_encode(array('result'=>'success','moudleId'=>$moudleid));
?>