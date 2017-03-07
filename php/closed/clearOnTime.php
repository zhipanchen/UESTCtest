<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/13
 * Time: 14:42
 */
    function clearOnTime()
    {
        require_once 'config.php';
        require_once 'session.php';
        require_once 'connect_db.php';

        $conn = connectDb();
        $timenow = time();
        $timereq = $timenow - TIME_LIMIT;
        $sql_a = "delete from x2_session where sessionlogintime<=$timereq";
        $conn->exec($sql_a);
        $sql_b = "delete from x2_user where userregtime<=$timereq and userstate=0";
        $conn->exec($sql_b);
        $conn=null;
    }
?>