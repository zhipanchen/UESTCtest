<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 6:38
 */
class history
{
    public function addHistory($args)
    {
        $userid = $args['userid'];
        $subjectid = $args['subjectid'];
        $questions = $args['questions'];
        $historytime = time();
        $historyusetime = $args['historyusetime'];
        $questionanswers = json_decode($questions);
        require_once 'question.php';
        $ques = new question();
        $queslist = $ques->getQuestionListBySubject($subjectid);
        $score = 0;
        $wrongnumber = 0;
        $wrongquestion=array();
        foreach ($questionanswers as $questionid => $answer) {
            foreach ($queslist['data'] as $value) {
                if ($questionid == $value['questionid']) {
                    if ($answer == $value['questioncorrectanswer']) {
                        $score += $value['questionscore'];
                    } else {
                        $wrongquestion[$questionid]=$answer;
                        $wrongnumber += 1;
                    }
                    break;
                }
            }
        }
        $wrongString = json_encode($wrongquestion);
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "insert into x2_history(userid,subjectid,questions,historywrongnumber,historytime,historyscore,historyusetime)" .
            "values ($userid,$subjectid,'$wrongString',$wrongnumber,$historytime,$score,$historyusetime)";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        $conn=null;
        return $id;
    }

    public function delHistoryById($historyid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_history where historyid=$historyid";
        $conn->exec($sql);
        $conn=null;
    }

    public function delHistoryBySubjectId($subjectid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_history where subjectid=$subjectid";
        $conn->exec($sql);
        $conn=null;
    }

    public function getHistoryById($historyid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="select * from x2_history where historyid=$historyid";
        $stmt = $conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $result;
    }

    public function getHistoryListByUserId($userid)
    {
        require_once 'connect_db.php';
        require_once 'subject.php';
        $conn = connectDb();
        $sql="select subjectname,historyscore,historytime,historywrongnumber from x2_history,x2_subject where userid=$userid and x2_history.subjectid=x2_subject.subjectid";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getPassUserBySubjectId($subjectid)
    {
        require_once 'connect_db.php';
        require_once 'subject.php';
        $conn = connectDb();
        $s = new subject();
        $passscore = $s->getPassScoreById($subjectid);
        $sql="select userid from x2_history where subjectid=$subjectid and historyscore>=$passscore group by userid";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getAverageScoreBySubjectId($subjectid)
    {
        require_once 'connect_db.php';
        $tmp = $this->getPassUserBySubjectId($subjectid);
        $userids = $tmp['data'];
        $number = $tmp['number'];
        $score=0;
        $conn = connectDb();
        foreach ($userids as $value)
        {
            $sql="select historyscore from x2_history where userid=$value[userid] order by historyscore DESC";
            $stmt = $conn->query($sql);
            $s = $stmt->fetch(PDO::FETCH_ASSOC);
            $score+=$s['historyscore'];
            $stmt=null;
        }
        $conn=null;
        if(is_int($average=$score/$number))
        {
            $average=$score/$number;
        }
        else
        {
            $average=intval($score/$number)+1;
        }
        return $average;
    }

    public function getHistoryByUserIdByHistoryTime($userid,$historytime)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="select * from x2_history where userid=$userid and historytime=$historytime";
        $stmt = $conn->query($sql);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $item;
    }

}