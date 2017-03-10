<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午4:28
 */
error_reporting(0);
require_once './closed/subject.php';

$s = new subject();
$result = array();
$subjects = $s->getSubjectList();
$temp=0;
foreach ($subjects['data'] as $subject)
{
    $result[$temp]['subjectid']=$subject['subjectid'];
    $result[$temp]['subjectName']=$subject['subjectname'];
    $result[$temp]['passLine']=$subject['subjectpassline'];
    $result[$temp]['totleScore']=$s->getTotleScore($subject['subjectid']);
    $temp+=1;
}
echo json_encode($result);
?>