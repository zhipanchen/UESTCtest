<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 2:24
 */
class user
{
    public function addUser($args)
    {
        require_once 'connect_db.php';
        require_once 'user_group.php';
        $u_g = new user_group();
        $username=$args['username'];
        $useremail=$args['useremail'];
        $userphone=$args['userphone'];
        $userpassword=md5($args['userpassword']);
        $userregip=$_SERVER["REMOTE_ADDR"];
        $userregtime=time();
        $usergroupid=$u_g->getDefaultGroupId();
        $usertruename=$args['usertruename'];
        $usercode=$args['usercode'];
        $conn = connectDb();
        $sql="insert into x2_user(username,useremail,userphone,userpassword,userregip,userregtime,usergroupid,usertruename,usercode)".
        "values ('$username','$useremail','$userphone','$userpassword','$userregip',$userregtime,$usergroupid,'$usertruename','$usercode')";
        $conn->exec($sql);
        $conn=null;
    }

    public function delUserByUserId($userid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        if($userid!=1)
        {
            $sql = "delete from x2_user where userid=$userid";
            $conn->exec($sql);
            // unlink()是删除文件的php函数
            unlink('photo/'.md5($userid).'.jpg');
        }
        $conn=null;
    }

    public function modUserById($args,$userid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        foreach ($args as $key => $arg)
        {
            $sql="update x2_user set $key='$arg' where userid='$userid'";
            $conn->exec($sql);
        }
        $conn=null;
    }

    public function modUserGroupById($userid,$groupid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_user set usergroupid=$groupid where userid=$userid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modUserPassWord($userid,$password)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $userpassword=md5($password);
        $sql="update x2_user set userpassword='$userpassword' where userid=$userid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modUserPhoto($userid,$photo)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_user set photo='$photo' where userid=$userid";
        $conn->exec($sql);
        $conn=null;
    }

    public function getUserList()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getUserById($userid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user where userid=$userid";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    public function getUserByUserName($username)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user where username='$username'";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    public function getUserByUserEmail($useremail)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user where useremail='$useremail'";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    public function getUserByUserTrueName($usertruename)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user where usertruename='$usertruename'";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    public function getUserByUserCode($usercode)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_user where usercode='$usercode'";
        $stmt = $conn->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    public function makeUserActiveById($userid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_user set userstate=1 where userid=$userid";
        $conn->exec($sql);
        $conn=null;
    }

    //input:sepnumber每页数量
    //output:用户页数
    public function getPagesNumber($sepnumber)
    {
        require_once 'config.php';
        if(!$sepnumber)$sepnumber = PN;
        $tmp = $this->getUserList();
        $number = $tmp['number'];
        if($number % $sepnumber)
            return intval($number/$sepnumber)+1;
        else
            return intval($number/$sepnumber);
    }

    //input page需要的页数，number每页数量
    //output:return results=array(data数据,number数据的数量,page页码总数)
    //按页码输出用户
    public function getUserLists($page,$number)
    {
        $page = $page>0?$page:1;
        require_once 'config.php';
        $number=$number>0?$number:PN;
        require_once 'connect_db.php';
        $conn = connectDb();
        $page=intval($page)-1;
        $number=intval($number);
        $tmp = $page*$number;
        $sql = "select * from x2_user limit $tmp,$number";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $results['page']=$this->getPagesNumber($number);
        $stmt=null;
        $conn=null;
        return $results;
    }

}