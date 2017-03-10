<?php
require_once './closed/data.php';
require_once './closed/session.php';
require_once './closed/config.php';
require_once './closed/module.php';
require_once './closed/user.php';

$moduleid=$_POST['moduleId'];
$page=$_POST['modulePage'];

$page=$page>0?$page:1;
$d=new data();
$s=new Session();
$u=new user();
$session=$s->getCurrentSession();
if(!$session){
    echo json_encode(array('result'=>'redirection'));
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
//{"moduleName":"\u8bed\u6587","totlePage":1,"dataNumber":6,"dataData":[{"dataid":"1","moduleid":"1","datainfo":"datainfo1","datachoicea":"dataa","datachoiceb":"datab","datachoicec":"datac","datachoiced":"datad","datanote":"note","datapicture":null,"datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"A","datascore":"1"},{"dataid":"2","moduleid":"1","datainfo":"datainfo1","datachoicea":"dataa","datachoiceb":"datab","datachoicec":"datac","datachoiced":"datad","datanote":"note","datapicture":null,"datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"A","datascore":"1"},{"dataid":"3","moduleid":"1","datainfo":"datainfo1","datachoicea":"dataa","datachoiceb":"datab","datachoicec":"datac","datachoiced":"datad","datanote":"note","datapicture":null,"datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"A","datascore":"1"},{"dataid":"4","moduleid":"1","datainfo":"datainfo1","datachoicea":"dataa","datachoiceb":"datab","datachoicec":"datac","datachoiced":"datad","datanote":"note","datapicture":null,"datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"A","datascore":"1"},{"dataid":"5","moduleid":"1","datainfo":"datainfo1","datachoicea":"dataa","datachoiceb":"datab","datachoicec":"datac","datachoiced":"datad","datanote":"note","datapicture":"files\/data\/1\/5\/data.jpg","datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"A","datascore":"1"},{"dataid":"6","moduleid":"1","datainfo":"datainfo1","datachoicea":"dataa","datachoiceb":"datab","datachoicec":"datac","datachoiced":"datad","datanote":"note","datapicture":"files\/data\/1\/6\/data.jpg","datapicturea":"files\/data\/1\/6\/a.jpg","datapictureb":"files\/data\/1\/6\/b.jpg","datapicturec":"files\/data\/1\/6\/c.jpg","datapictured":"files\/data\/1\/6\/d.jpg","datanotepicture":"files\/data\/1\/6\/note.jpg","dataanswer":"A","datascore":"1"}]}
?>