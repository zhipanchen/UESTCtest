<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/30
 * Time: 22:01
 */
class Session
{
    public function setSession($user)
    {
        require_once 'config.php';
        require_once 'connect_db.php';
        $conn = connectDb();
        session_start();
//        获取客户端ip   $_SERVER["REMOTE_ADDR"];
//        客户端id   session_id();
        $sid = session_id();
        $userid = $user['userid'];
        $username = $user['username'];
        $userpassword = $user['userpassword'];
        $sessionip = $_SERVER["REMOTE_ADDR"];
        $sessiongroupid = $user['usergroupid'];
        $times = time();
        $sql="INSERT INTO x2_session(sessionid,sessionuserid,sessionusername,sessionpassword,sessionip,sessiongroupid,sessionlogintime) VALUES ('$sid',$userid,'$username','$userpassword','$sessionip',$sessiongroupid,$times)";
        $conn->exec($sql);
        $conn=null;
        session_destroy();
        return $sid;
    }

    public function clearSession($sessionusername)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="delete from x2_session where sessionusername='$sessionusername'";
        $conn->exec($sql);
        $conn=null;
    }

    public function getSessionByUserName($sessionusername)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_session where sessionusername=$sessionusername";
        $stmt = $conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $result;
    }

    public function getCurrentSession()
    {
        session_start();
        $sid=session_id();
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="select * from x2_session where sessionid='$sid'";
        $stmt = $conn->query($sql);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);
        session_destroy();
        $stmt=null;
        $conn=null;
        return $session;
    }

}
?>