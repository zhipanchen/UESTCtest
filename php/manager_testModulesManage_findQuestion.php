<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/13
 * Time: 2:26
 */
    require_once 'closed/question.php';
    $word = $_POST['word'];
    $subjectid = $_POST['subjectid'];
    $q = new question();
    $list = $q->getQuestionInfoListByWord($word,$subjectid);
    echo json_encode($list);

//[{"questionid":"1","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"A","questionscore":"1"},{"questionid":"2","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"B","questionscore":"1"},{"questionid":"3","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},{"questionid":"4","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"D","questionscore":"1"},{"questionid":"5","subjectid":"1","questioninfo":"123","questionchoicea":"a","questionchoiceb":"bc","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},{"questionid":"6","subjectid":"2","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"A","questionscore":"1"},{"questionid":"7","subjectid":"2","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"B","questionscore":"1"},{"questionid":"8","subjectid":"2","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"C","questionscore":"1"},{"questionid":"9","subjectid":"2","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"D","questionscore":"1"},{"questionid":"10","subjectid":"2","questioninfo":"123","questionchoicea":"a","questionchoiceb":"b","questionchoicec":"c","questionchoiced":"d","questionnote":null,"questionpicture":null,"questionpicturea":null,"questionpictureb":null,"questionpicturec":null,"questionpictured":null,"questionnotepicture":null,"questioncorrectanswer":"A","questionscore":"1"}]
?>