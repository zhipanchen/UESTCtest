<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/1
 * Time: 1:41
 */
class question_app
{
    //输入：一个json,名args。args是数组，包括subjectid,questioninfo,questionchoicea,questionchoiceb,questionchoicec,questionchoiced,
    //questionnote(可以传null),questioncorrectanswer,questionscore。6个文件question,a,b,c,d,note
    //输出：无
    //添加题目
    public function addQuestion()
    {
        $args = json_decode($_POST['args']);
        $ques = $_FILES['question'];
        $a = $_FILES['a'];
        $b = $_FILES['b'];
        $c = $_FILES['c'];
        $d = $_FILES['d'];
        $note = $_FILES['note'];
        require_once 'dir.php';
        $di = new dir();
        $di->makeDirInFilesData("files");
        $di->makeDirInFilesData("files/question");
        $di->makeDirInFilesData("files/question/".$args['subjectid']);
        $di->makeDirInFilesData("files/question/".$args['subjectid'].'/'.md5($args['questioninfo']));
        $questionpicture = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/question.jpg";
        $questionpicturea = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/a.jpg";
        $questionpictureb = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/b.jpg";
        $questionpicturec = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/c.jpg";
        $questionpictured = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/d.jpg";
        $questionnotepicture = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/note.jpg";
        move_uploaded_file($ques['tmp_name'],$questionpicture);
        move_uploaded_file($a['tmp_name'],$questionpicturea);
        move_uploaded_file($b['tmp_name'],$questionpictureb);
        move_uploaded_file($c['tmp_name'],$questionpicturec);
        move_uploaded_file($d['tmp_name'],$questionpictured);
        move_uploaded_file($note['tmp_name'],$questionnotepicture);
        $args['questionpicture'] = $questionpicture;
        $args['questionpicturea'] = $questionpicturea;
        $args['questionpictureb'] = $questionpictureb;
        $args['questionpicturec'] = $questionpicturec;
        $args['questionpictured'] = $questionpictured;
        $args['questionnotepicture'] = $questionnotepicture;
        require_once 'question.php';
        $ques = new question();
        $ques->addQuestion($args);
    }

    //input:questionid
    //output:null
    //删除题目
    public function delQuestion()
    {
        $questionid = $_POST['questionid'];
        require_once 'question.php';
        $q = new question();
        $question = $q->getQuestionById($questionid);
        require_once 'dir.php';
        $d = new dir();
        $d->delDir('files/question/'.$question['subjectid'].'/'.md5($question['questioninfo']));
        $q->delQuestionById($questionid);
    }

    //输入：questionid,一个json,名args。args是数组，包括subjectid,questioninfo,questionchoicea,questionchoiceb,questionchoicec,questionchoiced,
    //questionnote(可以传null),questioncorrectanswer,questionscore。6个文件question,a,b,c,d,note
    //输出：无
    //修改题目
    public function modQuestion()
    {
        $questionid = $_POST['questionid'];
        $args = json_decode($_POST['args']);
        $ques = $_FILES['question'];
        $a = $_FILES['a'];
        $b = $_FILES['b'];
        $c = $_FILES['c'];
        $d = $_FILES['d'];
        $note = $_FILES['note'];
        require_once 'dir.php';
        $di = new dir();
        $di->makeDirInFilesData("files");
        $di->makeDirInFilesData("files/question");
        $di->makeDirInFilesData("files/question/".$args['subjectid']);
        $di->makeDirInFilesData("files/question/".$args['subjectid'].'/'.md5($args['questioninfo']));
        $questionpicture = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/question.jpg";
        $questionpicturea = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/a.jpg";
        $questionpictureb = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/b.jpg";
        $questionpicturec = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/c.jpg";
        $questionpictured = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/d.jpg";
        $questionnotepicture = "files/question/".$args['subjectid']."/".md5($args['questioninfo'])."/note.jpg";
        if($ques) {
            move_uploaded_file($ques['tmp_name'], $questionpicture);
        }
        if($a) {
            move_uploaded_file($a['tmp_name'], $questionpicturea);
        }
        if($b) {
            move_uploaded_file($b['tmp_name'], $questionpictureb);
        }
        if($c) {
            move_uploaded_file($c['tmp_name'], $questionpicturec);
        }
        if($d) {
            move_uploaded_file($d['tmp_name'], $questionpictured);
        }
        if($note) {
            move_uploaded_file($note['tmp_name'], $questionnotepicture);
        }
        $args['questionpicture'] = $questionpicture;
        $args['questionpicturea'] = $questionpicturea;
        $args['questionpictureb'] = $questionpictureb;
        $args['questionpicturec'] = $questionpicturec;
        $args['questionpictured'] = $questionpictured;
        $args['questionnotepicture'] = $questionnotepicture;
        require_once 'question.php';
        $ques = new question();
        $ques->modQuestionById($args,$questionid);
    }

}