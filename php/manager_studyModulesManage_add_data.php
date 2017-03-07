<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午6:06
 */

error_reporting(0);
//$args = json_decode($_POST['args']);
$args['moduleid']=$_POST['moduleid'];
$args['datainfo']=$_POST['datainfo'];
$args['datachoicea']=$_POST['datachoicea'];
$args['datachoiceb']=$_POST['datachoiceb'];
$args['datachoicec']=$_POST['datachoicec'];
$args['datachoiced']=$_POST['datachoiced'];
$args['datanote']=$_POST['datanote'];
$args['datascore']=$_POST['datascore'];

if($_POST['A']=="on"){
    $args['dataanswer']='A';
}
if($_POST['B']=="on"){
    $args['dataanswer']='B';
}
if($_POST['C']=="on"){
    $args['dataanswer']='C';
}
if($_POST['D']=="on"){
    $args['dataanswer']='D';
}

$ques = $_FILES['data'];
$a = $_FILES['a'];
$b = $_FILES['b'];
$c = $_FILES['c'];
$d = $_FILES['d'];
$note = $_FILES['note'];

require_once './closed/data.php';
$dataa = new data();
$dataid = $dataa->addData($args);
require_once './closed/dir.php';
$di = new dir();
$di->makeDirInFilesData("files");
$di->makeDirInFilesData("files/data");
$di->makeDirInFilesData("files/data/".$args['moduleid']);
$di->makeDirInFilesData("files/data/".$args['moduleid'].'/'.$dataid);
$datapicture = "files/data/".$args['moduleid']."/".$dataid."/data.jpg";
$datapicturea = "files/data/".$args['moduleid']."/".$dataid."/a.jpg";
$datapictureb = "files/data/".$args['moduleid']."/".$dataid."/b.jpg";
$datapicturec = "files/data/".$args['moduleid']."/".$dataid."/c.jpg";
$datapictured = "files/data/".$args['moduleid']."/".$dataid."/d.jpg";
$datanotepicture = "files/data/".$args['moduleid']."/".$dataid."/note.jpg";
move_uploaded_file($ques['tmp_name'],$datapicture);
move_uploaded_file($a['tmp_name'],$datapicturea);
move_uploaded_file($b['tmp_name'],$datapictureb);
move_uploaded_file($c['tmp_name'],$datapicturec);
move_uploaded_file($d['tmp_name'],$datapictured);
move_uploaded_file($note['tmp_name'],$datanotepicture);

$arg=array();
if($ques)
{
    $arg['datapicture'] = $datapicture;
}
if($a)
{
    $arg['datapicturea'] = $datapicturea;
}
if($b)
{
    $arg['datapictureb'] = $datapictureb;
}
if($c)
{
    $arg['datapicturec'] = $datapicturec;
}
if($d)
{
    $arg['datapictured'] = $datapictured;
}
if($note)
{
    $arg['datanotepicture'] = $datanotepicture;
}
$dataa->modDataById($arg,$dataid);
echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>