<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午8:23
 */
    require_once './closed/user.php';
    require_once './closed/config.php';
    require_once './closed/session.php';
    $page=$_POST['page'];
    $page = $page>0?$page:1;
    $u = new user();
    $s = new Session();

    $session = $s->getCurrentSession();
    if(!$session){
        echo json_encode(array('result'=>'redirection'));
    }else{
        $list = $u->getUserLists($page,PN);
        $user = $u->getUserById($session['sessionuserid']);
        echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'list'=>$list));
    };
//{"username":"peadmin","photo":"123","list":{"data":[{"userid":"1","username":"peadmin","useremail":"531489023@qq.com","userphone":"123","userpassword":"244153a2599be7685c32d2281f57ae67","userregip":"127.0.0.1","userregtime":"0","userlogtime":"0","usergroupid":"1","photo":"123","usertruename":"admin","usercode":"123","userstate":"1"},{"userid":"2","username":"xiaohua","useremail":"123","userphone":"123","userpassword":"123","userregip":"123","userregtime":"0","userlogtime":"0","usergroupid":"123","photo":"123","usertruename":"123","usercode":"123","userstate":"1"}],"number":2,"page":1}}
?>