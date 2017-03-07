<?php

require_once './closed/session.php';
require_once './closed/subject.php';
require_once './closed/user.php';

$S=new Session();
$u=new user();
$session=$S->getCurrentSession();
if(!$session){
    echo json_encode(array('result'=>'redirection'));
}else{
    $user = $u->getUserById($session['sessionuserid']);
    $username=$session['sessionusername'];
    $m=new subject();
    $subject=$m->getSubjectList();
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'list'=>$subject));
//{"username":"peadmin","photo":"123","list":{"data":[{"subjectid":"1","subjectname":"\u8bed\u6587","subjectstate":"1","subjectpassline":"60"},{"subjectid":"2","subjectname":"\u6570\u5b66","subjectstate":"1","subjectpassline":"60"}],"number":2}}
};
?>
