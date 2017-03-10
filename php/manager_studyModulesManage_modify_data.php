<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午6:30
 */
error_reporting(0);

$dataid = $_POST['dataid'];

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
require_once './closed/data.php';
$que = new data();
if($ques) {
    move_uploaded_file($ques['tmp_name'], $datapicture);
    $que->modDataById(array('datapicture'=>$datapicture),$dataid);
}
if($a) {
    move_uploaded_file($a['tmp_name'], $datapicturea);
    $que->modDataById(array('datapicturea'=>$datapicturea),$dataid);
}
if($b) {
    move_uploaded_file($b['tmp_name'], $datapictureb);
    $que->modDataById(array('datapictureb'=>$datapictureb),$dataid);
}
if($c) {
    move_uploaded_file($c['tmp_name'], $datapicturec);
    $que->modDataById(array('datapicturec'=>$datapicturec),$dataid);
}
if($d) {
    move_uploaded_file($d['tmp_name'], $datapictured);
    $que->modDataById(array('datapictured'=>$datapictured),$dataid);
}
if($note) {
    move_uploaded_file($note['tmp_name'], $datanotepicture);
    $que->modDataById(array('datanotepicture'=>$datanotepicture),$dataid);
}

if($args['datainfo'])
{
    $arg['datainfo']=$args['datainfo'];
    $que->modDataById($arg,$dataid);
}
if($args['datachoicea'])
{
    $arg['datachoicea']=$args['datachoicea'];
    $que->modDataById($arg,$dataid);
}
if($args['datachoiceb'])
{
    $arg['datachoiceb']=$args['datachoiceb'];
    $que->modDataById($arg,$dataid);
}
if($args['datachoicec'])
{
    $arg['datachoicec']=$args['datachoicec'];
    $que->modDataById($arg,$dataid);
}
if($args['datachoiced'])
{
    $arg['datachoiced']=$args['datachoiced'];
    $que->modDataById($arg,$dataid);
}
if($args['datanote'])
{
    $arg['datanote']=$args['datanote'];
    $que->modDataById($arg,$dataid);
}
if($args['dataanswer'])
{
    $arg['dataanswer']=$args['dataanswer'];
    $que->modDataById($arg,$dataid);
}
if($args['moduleid'])
{
    $que->modDataModuleIdById($args['moduleid'],$dataid);
}
if($args['datascore'])
{
    $que->modDataScoreById($args['datascore'],$dataid);
}
echo json_encode(array('result'=>'success'));
?>

