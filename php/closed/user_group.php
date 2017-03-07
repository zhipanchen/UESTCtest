<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 1:00
 */
class user_group
{
    public function addUserGroup($args)
    {
        require_once 'connect_db.php';
        $groupname =  $args['groupname'];
        $conn = connectDb();
        $sql = "insert into x2_user_group(groupname) values ($groupname)";
        $conn->exec($sql);
        $conn=null;
    }

    public function delUserGroupById($groupid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_user_group where groupid=$groupid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modUserGroupByGroupId($args,$groupid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        foreach ($args as $key => $arg)
        {
            $sql="update x2_user_group set $key='$arg' where groupid='$groupid'";
            $conn->exec($sql);
        }
        $conn=null;
    }

    public function getDefaultGroupId()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="select * from x2_user_group where groupdefault=1";
        $stmt = $conn->query($sql);
        $user_group = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user_group['groupid'];
    }

    public function getGroupList()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user_group";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }
}