<?php
error_reporting(0);
require_once './closed/data.php';
require_once './closed/session.php';
require_once './closed/config.php';
require_once './closed/module.php';
require_once './closed/user.php';
error_reporting(0);
$moduleid=$_POST['moduleId'];
$page=$_POST['modulePage'];

$page=$page>0?$page:1;
$d=new data();
$s=new Session();
$u=new user();
$session=$s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=1)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else{
    $result=$d->getDataListsByModuleId($moduleid,$page,PN);
    $res=array();
    $m = new module();
    $module = $m->getModuleById($moduleid);
    $res['moduleName']=$module['modulename'];
    $res['totlePage']=$result['page'];
    $res['dataNumber']=$result['number'];
    $res['dataData']=$result['data'];
    $user=$u->getUserById($session['sessionuserid']);
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'res'=>$res));
};
?>