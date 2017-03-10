<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/18
 * Time: 15:50
 */
error_reporting(0);
$dataid = $_POST['dataid'];
require_once 'closed/data.php';
$d = new data();
$data = $d->getDataById($dataid);
echo json_encode($data);
?>