<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午4:00
 */
error_reporting(0);
require_once './closed/history.php';
require_once './closed/subject.php';
require_once './closed/session.php';
require_once './closed/user.php';

$h = new history();
$s = new subject();
$ss = new Session();
$u = new user();
$session=$ss->getCurrentSession();
if(!$session||($session['sessiongroupid']!=1)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else{
    $user = $u->getUserById($session['sessionuserid']);
    $result = array();
    $subjects = $s->getSubjectList();
    $temp=0;
    foreach ($subjects['data'] as $item)
    {
        $result[$temp]['subjectname']=$item['subjectname'];
        $result[$temp]['passsocre']=$s->getPassScoreById($item['subjectid']);
        $result[$temp]['totalscore']=$s->getTotleScore($item['subjectid']);
        $result[$temp]['averagescore']=$h->getAverageScoreBySubjectId($item['subjectid']);
        $userList = $h->getPassUserBySubjectId($item['subjectid']);
        $result[$temp]['passnumber']=$userList['number'];
        $tmp=0;
        foreach ($userList['data'] as $value)
        {
            $usertemp = $u->getUserById($value['userid']);
            $result[$temp]['data'][$tmp]['usertruename']=$usertemp['usertruename'];
            $result[$temp]['data'][$tmp]['usercode']=$usertemp['usercode'];
            $tmp+=1;
        }
        $temp+=1;
    }
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'result'=>$result));
};
?>