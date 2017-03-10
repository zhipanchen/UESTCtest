<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/17
 * Time: 15:03
 */
error_reporting(0);
$args = $_POST['questionids'];
$questionids = json_decode($args);
require_once './closed/question.php';
require_once './closed/dir.php';
$d = new dir();
$q = new question();
if(is_array($questionids))
{
    foreach ($questionids as $questionid)
    {
        $question = $q->getQuestionById($questionid);
        $d->delDir('files/question/'.$question['subjectid'].'/'.$questionid);
        $q->delQuestionById($questionid);

    }
}
echo json_encode(array('result'=>'success'));
?>

