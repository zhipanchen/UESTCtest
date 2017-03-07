<!DOCTYPE html>
<html>
    <head>
        用户激活
    </head>
    <body>
        <?php
        require_once 'user.php';
        require_once 'encrypt.php';
        require_once 'config.php';
        require_once 'session.php';
        $crypt = $_GET['userid'];
        $u = new user();
        $e = new encrypt();
        $s = new Session();
        $userid = $e->passport_decrypt($crypt,SEC);
        $user = $u->getUserById($userid);
        if($user)
        {
            $u->makeUserActiveById($userid);
            echo "激活成功！"."<br/>."."三秒后自动跳转";
            sleep(3);
            $s->setSession($user);
            if($user['usergroupid']==1)
            {
                header("Location:");//跳转到管理员
            }
            elseif($user['usergroupid']==2)
            {
                header("Location:");//跳转到普通用户
            }
        }
        else
        {
            echo "您已超时，请重新注册"."<br/>"."三秒后自动跳转";
            sleep(3);
            header("Location:");//跳转到注册
        }
        ?>
    </body>
</html>
