<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:19
 */
error_reporting(0);
$historytime=$_POST['historytime'];
require_once './closed/history.php';
require_once './closed/session.php';
require_once './closed/question.php';

$h = new history();
$s = new Session();
$q = new question();

$session = $s->getCurrentSession();

$history = $h->getHistoryByUserIdByHistoryTime($session['sessionuserid'],$historytime);
$questionlist = $q->getQuestionListBySubject($history['subjectid']);
$result = array();
$wrongquestions = json_decode($history['questions']);
$temp=0;
foreach ($wrongquestions as $questionid => $questionchoice)
{
    foreach ($questionlist['data'] as $question)
    {
        if($questionid == $question['questionid'])
        {
            $result[$temp]['questiondata']=$question;
            $result[$temp]['wrongchoice']=$questionchoice;
        }
    }
    $temp+=1;
}
echo json_encode($result);
?>

