<?php
error_reporting(0);
require_once './closed/subject.php';
$args['subjectname']=$_POST['subjectName'];
$args['subjectpassline']=$_POST['subjectpassline'];
$s=new subject();
$fob=array('<','>',',','.','?','/',';',':','"',"'",'[',']','{','}','|','\\','+','=','-','_','!','@','#','$','%','^','&','*','(',')','~','`');
foreach ($fob as $f)
{
    if(strpos($args['subjectname'],$f) !== false)
    {
        echo json_encode(array('result'=>'fail'));
        exit(0);
    }
}
if($s->getSubjectByName($args['subjectname']))
{
    echo json_encode(array('result'=>'fail'));
    exit(0);
}
if((strlen($args['subjectname'])<=0) || (strlen($args['subjectname'])>10))
{
    echo json_encode(array('result'=>'fail'));
    exit(0);
}
$subjectid=$s->addSubject($args);
echo json_encode(array('result'=>'success','subjectid'=>$subjectid));
?>
