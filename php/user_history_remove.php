<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/19
 * Time: 14:00
 */
error_reporting(0);
require_once 'closed/history.php';
$historyid = $_POST['historyid'];
$h = new history();
$h->delHistoryById($historyid);
echo json_encode(array('result'=>'success'));
?>