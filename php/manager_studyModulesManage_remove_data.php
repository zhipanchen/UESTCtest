<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午6:26
 */
error_reporting(0);
$dataid = $_POST['dataid'];
require_once './closed/data.php';
$q = new data();
$data = $q->getDataById($dataid);
require_once './closed/dir.php';
$d = new dir();
$d->delDir('files/data/'.$data['moduleid'].'/'.$dataid);
$q->delDataById($dataid);
echo json_encode(array('result'=>'success'));
?>