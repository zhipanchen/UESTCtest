<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:10
 */

require_once './closed/history.php';
require_once './closed/session.php';
require_once './closed/user.php';

$h = new history();
$s = new Session();
$u = new user();

$session = $s->getCurrentSession();
if(!$session){
    echo json_encode(array('result'=>'redirection'));
}else{
    $user=$u->getUserById($session['sessionuserid']);
    $list = $h->getHistoryListByUserId($session['sessionuserid']);
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'list'=>$list));
//    {"username":"peadmin","photo":"123","list":{"data":[{"subjectname":"\u8bed\u6587","historyscore":"3","historytime":"1484276528","historywrongnumber":"4"},{"subjectname":"\u6570\u5b66","historyscore":"1","historytime":"1484276607","historywrongnumber":"4"}],"number":2}}
};

?>
