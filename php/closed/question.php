<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 4:50
 */
class question
{
    public function addQuestion($args)
    {
        require_once 'connect_db.php';
        $subjectid=$args['subjectid'];
        $questioninfo=$args['questioninfo'];
        $questionchoicea=$args['questionchoicea'];
        $questionchoiceb=$args['questionchoiceb'];
        $questionchoicec=$args['questionchoicec'];
        $questionchoiced=$args['questionchoiced'];
        $questioncorrectanswer=$args['questioncorrectanswer'];
        $questionnote=$args['questionnote'];
        $questionscore=$args['questionscore'];
        $conn = connectDb();
        $sql="insert into x2_question(subjectid,questioninfo,questionchoicea,questionchoiceb,".
            "questionchoicec,questionchoiced,questioncorrectanswer,questionnote,questionscore) ".
            "values ($subjectid,'$questioninfo','$questionchoicea','$questionchoiceb',".
            "'$questionchoicec','$questionchoiced','$questioncorrectanswer','$questionnote',$questionscore)";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        $conn=null;
        return $id;
    }


    public function delQuestionById($questionid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_question where questionid=$questionid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modQuestionById($args,$questionid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        foreach ($args as $key => $value)
        {
            $sql = "update x2_question set $key='$value' where questionid=$questionid";
            $conn->exec($sql);
        }
        $conn=null;
    }

    public function modQuestionSubjectIdById($subjectid,$questionid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "update x2_question set subjectid=$subjectid where questionid=$questionid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modQuestionScoreById($questionscore,$questionid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "update x2_question set questionscore=$questionscore where questionid=$questionid";
        $conn->exec($sql);
        $conn=null;
    }

    public function getQuestionListBySubject($subjectid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_question where subjectid=$subjectid";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getQuestionById($questionid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_question where questionid=$questionid";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    //input:subjectid,sepnumber每页数量
    //output:subjectid对应科目的题目页数
    public function getPagesNumber($subjectid,$sepnumber)
    {
        require_once 'config.php';
        if(!$sepnumber)$sepnumber = PN;
        $tmp = $this->getQuestionListBySubject($subjectid);
        $number = $tmp['number'];
        if($number % $sepnumber)
            return intval($number/$sepnumber)+1;
        else
            return intval($number/$sepnumber);
    }

    //input subjectid科目id，page需要的页数，number每页数量
    //output:return results=array(data数据,number数据的数量,page页码总数)
    //按页码输出题目
    public function getQuestionListsBySubjectId($subjectid,$page,$number)
    {
        $page = $page>0?$page:1;
        require_once 'config.php';
        $number=$number>0?$number:PN;
        require_once 'connect_db.php';
        $conn = connectDb();
        $page=intval($page)-1;
        $number=intval($number);
        $tmp = $page*$number;
        $sql = "select * from x2_question where subjectid=$subjectid limit $tmp,$number";
        $stmt = $conn->query($sql);
        $results['data']  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $results['page']=$this->getPagesNumber($subjectid,$number);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getQuestionInfoListByWord($word,$subjectid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_question where subjectid=$subjectid";
        $stmt = $conn->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        $list = array();
        foreach ($results as $result)
        {
            if(strstr($result['questioninfo'],$word))
            {
                $list[] = $result;
            }
        }
        return $list;
    }
}