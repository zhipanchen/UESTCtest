<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 23:29
 */
class user_app
{
    //输入两个值，username,userpassword
    //输出三个值json，username,password,userstate。1表示正确
    //登录
    public function login()
    {
        require_once 'config.php';
        require_once 'session.php';
        require_once 'connect_db.php';
        $s = new Session();
        $conn = connectDb();
        //$username=$_POST['username'];
        //$password=$_POST['password'];
        $username="peadmin";
        $password="peadmin";
        $sql="SELECT * FROM x2_user WHERE username= '$username'";
        $result = mysql_query($sql);
        $user = mysql_fetch_array($result,MYSQL_ASSOC);
        if($user)
        {
            if($user['userstate']=0)
            {
                $message['userstate']=0;
                $message['username']=1;
                $message['password']=0;
            }
            else
            {
                if($user['userpassword']==md5($password))
                {
                    $message['userstate']=1;
                    $message['username']=1;
                    $message['password']=1;
                    $s->setSession($user);
                }
                else
                {
                    $message['userstate']=1;
                    $message['username']=1;
                    $message['password']=0;
                }
            }
        }
        else
        {
            $message['userstate']=0;
            $message['username']=0;
            $message['password']=0;
        }
        echo json_encode($message);
        mysql_close($conn);
    }

    //输入：传入一个json,json名args,args是一个数组，其中有username,useremail,userphone,userpassword,usertruename,usercode
    //输出：json格式的数字，1代表username已注册，2代表useremail已注册，3代表真实姓名和学号的组合已注册，5代表注册成功，已经发送了邮件
    //注册
    public function register()
    {
        $args=json_decode($_POST['args']);
        $username=$args['username'];
        $useremail=$args['useremail'];
        $userphone=$args['userphone'];
        $userpassword=md5($args['userpassword']);
        $usertruename=$args['usertruename'];
        $usercode=$args['usercode'];
        require_once 'user.php';
        $u = new user();
        if($u->getUserByUserName($username))
        {
            echo json_decode("1");
        }
        else
        {
            if($u->getUserByUserEmail($useremail))
            {
                echo json_encode("2");
            }
            else
            {
                $user = $u->getUserByUserTrueName($usertruename);
                if ($user && ($usercode == $user['usercode']))
                {
                    echo json_encode("3");
                }
                else
                {
                    $u->addUser($args);
                    require_once 'email.php';
                    $e = new email();
                    $e->sendActiveLinkToUser($username,$useremail,SEC);
                    echo json_encode("5");
                }
            }
        }
    }

    //输入两个值，userid,oldpassword,password
    //输出：json成功1，失败0
    //修改密码
    public function modPassWord()
    {
        require_once 'user.php';
        $u = new user();
        $userid=$_POST['userid'];
        $oldpassword=$_POST['oldpassword'];
        $password=$_POST['password'];
        $user = $u->getUserById($userid);
        if($user['userpassword']==$oldpassword)
        {
            $u->modUserPassWord($userid,$password);
            echo json_encode("1");
        }
        else
        {
            echo json_encode("0");
        }
    }

    //输入：useremail
    //输出：随机数的json
    //发随机数
    public function forgetPassWord()
    {
        $useremail = $_POST['userEmail'];
        require_once 'email.php';
        $e = new email();
        $rand = $e->sendRandEmailToUser($useremail);
        echo json_encode(array('result'=>$rand));
    }

    //input:file形式的photo，userid
    //output:null
    //存储上传头像到photo/md5(userid).jpg，更改数据库中下x2_user表的photo值
    public function sentPhoto()
    {
        $photo = $_FILES['photo'];
        $userid = $_POST['userid'];
        require_once 'dir.php';
        $d = new dir();
        $d->makeDirInFilesData('photo');
        $path = 'photo/'.$userid.'.jpg';
        move_uploaded_file($photo['tmp_name'],$path);
        require_once 'user.php';
        $u = new user();
        $u->modUserPhoto($userid,$path);
    }
}