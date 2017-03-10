<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/19
 * Time: 15:38
 */
error_reporting(0);
require_once 'closed/myTime.php';
$time = (array)json_decode($_POST['time']);
$start = $time['start'];
$end = $time['end'];
$t = new My_time();
$pattern = "/^([0-9]{4,4})-([0-9]{1,2})-([0-9]{1,2})$/i";
if (isset($start) && isset($end))
{
    if ( preg_match( $pattern, $start ))
    {
        $start_year = intval(preg_replace( $pattern ,"$1", $start ));
        $start_month = intval(preg_replace( $pattern ,"$2", $start ));
        $start_day = intval(preg_replace( $pattern ,"$3", $start ));
        if(!$t->isTime($start_year,$start_month,$start_day))
        {
            echo json_encode(array('result'=>'reject_start'));
            exit(0);
        }
        $start_str = $start_year."-".$start_month."-".$start_day;
    }
    else
    {
        echo json_encode(array('result'=>'reject_start'));
        exit(0);
    }
    if ( preg_match( $pattern, $end ))
    {
        $end_year = intval(preg_replace( $pattern ,"$1", $end ));
        $end_month = intval(preg_replace( $pattern ,"$2", $end ));
        $end_day = intval(preg_replace( $pattern ,"$3", $end ));
        if(!$t->isTime($end_year,$end_month,$end_day))
        {
            echo json_encode(array('result'=>'reject_end'));
            exit(0);
        }
        $end_str = $end_year."-".$end_month."-".$end_day;
    }
    else
    {
        echo json_encode(array('result'=>'reject_end'));
        exit(0);
    }
}
$start_time = strtotime($start_str);
$end_time = strtotime($end_str);
if((!$start_time) || (!$end_time))
{
    echo json_encode(array('result'=>'reject'));
    exit(0);
}
$t->setRegTime($start_time,$end_time);
//$time = $t->getRegTime();
//echo date("Y-m-d H:i",$time['timestart'])."<br>";
//echo date("Y-m-d H:i",$time['timeend'])."<br>";
echo json_encode(array('result'=>'success'));
exit(0);
?>