<?php

require_once './closed/session.php';
require_once './closed/module.php';
require_once './closed/user.php';

$s=new Session();
$u=new user();
$session=$s->getCurrentSession();
if(!$session){
    echo json_encode(array('result'=>'redirection'));
}else{
    $user=$u->getUserById($session['sessionuserid']);
    $m=new module();
    $moudle=$m->getModuleList();
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'list'=>$moudle));
};
//{"username":"peadmin","photo":"123","list":{"data":[{"moduleid":"1","modulename":"\u8bed\u6587","modulestate":"1"},{"moduleid":"2","modulename":"\u6570\u5b66","modulestate":"1"}],"number":2}}
?>
