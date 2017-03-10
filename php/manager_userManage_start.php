<?php
error_reporting(0);
    require_once './closed/user.php';
    require_once './closed/config.php';
    require_once './closed/session.php';
    $page=$_POST['page'];
    $page = $page>0?$page:1;
    $u = new user();
    $s = new Session();

    $session = $s->getCurrentSession();
    if(!$session||($session['sessiongroupid']!=1)){
        echo json_encode(array('result'=>'redirection'));
        require_once 'logout.php';
        exit(0);
    }else{
        $list = $u->getUserLists($page,PN);
        $user = $u->getUserById($session['sessionuserid']);
        echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'list'=>$list));
    }
?>