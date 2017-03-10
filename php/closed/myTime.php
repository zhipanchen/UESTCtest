<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/19
 * Time: 15:43
 */
class My_time
{
    public function setRegTime($start, $end)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "update x2_time set timestart=$start,timeend=$end where timeid=1";
        $conn->exec($sql);
        $conn=null;
    }

    public function getRegTime()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select timestart,timeend,timestate from x2_time where timeid=1";
        $stmt = $conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $result;
    }

    public function isTime($year, $month, $day)
    {
        $result = false;
        if(($year<2017) || ($year>2099) || ($month<1) ||($month>12) || ($day<1) || ($day>31))
        {
            return $result;
        }
        if($year/4)
        {
            switch ($month)
            {
                case '2':
                    if($day>29)
                    {
                        return $result;
                    }
                    break;
                case '4':
                case '6':
                case '9':
                case '11':
                    if($day>30)
                    {
                        return $result;
                    }
                    break;
            }
        }
        else
        {
            switch ($month)
            {
                case '2':
                    if($day>28)
                    {
                        return $result;
                    }
                    break;
                case '4':
                case '6':
                case '9':
                case '11':
                    if($day>30)
                    {
                        return $result;
                    }
                    break;
            }
        }
        $result = true;
        return $result;
    }

}