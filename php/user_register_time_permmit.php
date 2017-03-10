<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/21
 * Time: 18:52
 */
error_reporting(0);
require_once 'closed/myTime.php';
$t = new My_time();
$time_set = $t->getRegTime();
$time_now = time();
if(($time_now>$time_set['timestart']) && ($time_now<$time_set['timeend']))
{
    echo json_encode(array('result'=>'success'));
    exit(0);
}
else
{
    echo json_encode(array('result'=>'false','start'=>date("Y-m-d",$time_set['timestart']),'end'=>date("Y-m-d",$time_set['timeend'])));
    exit(0);
}
?>