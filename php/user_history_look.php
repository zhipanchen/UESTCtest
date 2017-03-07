<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午9:19
 */

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
//[{"questiondata":{"questionid":"2","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"B","questionscore":"1"},"wrongchoice":"A"},{"questiondata":{"questionid":"3","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},"wrongchoice":"A"},{"questiondata":{"questionid":"4","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"D","questionscore":"1"},"wrongchoice":"A"},{"questiondata":{"questionid":"5","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"bc","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},"wrongchoice":"A"}]
?>

