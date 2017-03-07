<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 4:09
 */
class subject
{
    public function addSubject($args)
    {
        require_once 'connect_db.php';
        $subjectname=$args['subjectname'];
        $subjectpassline=$args['subjectpassline'];
        $conn = connectDb();
        $sql = "insert into x2_subject(subjectname,subjectpassline) values ('$subjectname',$subjectpassline)";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        $conn=null;
        return $id;
    }

    public function delSubjectById($subjectid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_subject where subjectid=$subjectid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modSubjectState($subjectid,$subjectstate)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_subject set subjectstate=$subjectstate where subjectid=$subjectid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modSubjectName($subjectid,$subjectname)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_subject set subjectname='$subjectname' where subjectid=$subjectid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modSubjectPassLine($subjectid,$subjectpassline)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_subject set subjectpassline=$subjectpassline where subjectid=$subjectid";
        $conn->exec($sql);
        $conn=null;
    }

    public function getSubjectList()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_subject";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getActiveSubject()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_subject where subjectstate=1";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getSubjectById($subjectid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_subject where subjectid=$subjectid";
        $stmt = $conn->query($sql);
        $subject = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $subject;
    }

    public function getSubjectStateById($subjectid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_subject where subjectid=$subjectid";
        $stmt = $conn->query($sql);
        $subject = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $subject['subjectstate'];
    }

    public function getSubjectByName($subjectname)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_subject where subjectname='$subjectname'";
        $stmt = $conn->query($sql);
        $subject = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $subject;
    }

    public function getTotleScore($subjectid)
    {
        require_once 'question.php';
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_question where subjectid=$subjectid";
        $stmt = $conn->query($sql);
        $totle=0;
        while($question = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $totle+=$question['questionscore'];
        }
        return $totle;
    }

    public function getPassScoreById($subjectid)
    {
        $total = $this->getTotleScore($subjectid);
        $subject  = $this->getSubjectById($subjectid);
        $passLine = $subject['subjectpassline'];
        return intval($total*$passLine/100);
    }

}