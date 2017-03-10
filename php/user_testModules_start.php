<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:47
 */

require_once './closed/subject.php';
require_once './closed/session.php';
require_once './closed/user.php';

$m = new subject();
$u = new user();
$s = new Session();
$session = $s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=2)){
    echo json_encode(array('result'=>'redirection'));
}else {
    $user = $u->getUserById($session['sessionuserid']);
    $subjects = $m->getActiveSubject();
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'result'=>$subjects));
}
//{"username":"peadmin","photo":"123","result":{"data":[{"subjectid":"1","subjectname":"\u8bed\u6587","subjectstate":"1","subjectpassline":"60"},{"subjectid":"2","subjectname":"\u6570\u5b66","subjectstate":"1","subjectpassline":"60"}],"number":2}}
?>
