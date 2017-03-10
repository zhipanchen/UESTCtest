<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/19
 * Time: 17:02
 */
error_reporting(0);
require_once 'closed/myTime.php';
$t = new My_time();
$time_set = $t->getRegTime();
$time_ret = array('start'=>date("Y-m-d",$time_set['timestart']),'end'=>date("Y-m-d",$time_set['timeend']));
echo json_encode($time_ret);
?>