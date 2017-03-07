<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 4:50
 */
class data
{
    public function addData($args)
    {
        require_once 'connect_db.php';
        $moduleid=$args['moduleid'];
        $datainfo=$args['datainfo'];
        $datachoicea=$args['datachoicea'];
        $datachoiceb=$args['datachoiceb'];
        $datachoicec=$args['datachoicec'];
        $datachoiced=$args['datachoiced'];
        $dataanswer=$args['dataanswer'];
        $datanote=$args['datanote'];
        $datascore=$args['datascore'];
        $conn = connectDb();
        $sql="insert into x2_data(moduleid,datainfo,datachoicea,datachoiceb,".
            "datachoicec,datachoiced,dataanswer,datanote,datascore) ".
            "values ($moduleid,'$datainfo','$datachoicea','$datachoiceb',".
            "'$datachoicec','$datachoiced','$dataanswer','$datanote',$datascore)";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        $conn=null;
        return $id;
    }

    public function delDataById($dataid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_data where dataid=$dataid";
        $res = $conn->exec($sql);
        $conn=null;
        return $res;
    }

    public function modDataById($args,$dataid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        foreach ($args as $key => $value)
        {
            $sql = "update x2_data set $key='$value' where dataid=$dataid";
            $conn->exec($sql);
        }
        $conn=null;
    }

    public function modDataModuleIdById($moduleid,$dataid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "update x2_data set moduleid=$moduleid where dataid=$dataid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modDataScoreById($datascore,$dataid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "update x2_data set datascore=$datascore where dataid=$dataid";
        $conn->exec($sql);
        $conn=null;
    }

    public function getDataListByModule($moduleid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_data where moduleid=$moduleid";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        $results['number']=count($results['data']);
        return $results;
    }

    public function getDataById($dataid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="select * from x2_data where dataid=$dataid";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $user;
    }

    //input:moduleid,sepnumber每页数量
    //output:moduleid对应module的题目页数
    public function getPagesNumber($moduleid,$sepnumber)
    {
        require_once 'config.php';
        if(!$sepnumber)$sepnumber = PN;
        $tmp = $this->getDataListByModule($moduleid);
        $number = $tmp['number'];
        if($number % $sepnumber)
            return intval($number/$sepnumber)+1;
        else
            return intval($number/$sepnumber);
    }

    //input moduleid，page需要的页数，number每页数量
    //output:return results=array(data数据,number数据的数量,page页码总数)
    //按页码输出data
    public function getDataListsByModuleId($moduleid,$page,$number)
    {
        $page = $page>0?$page:1;
        require_once 'config.php';
        $number=$number>0?$number:PN;
        require_once 'connect_db.php';
        $conn = connectDb();
        $page=intval($page)-1;
        $number=intval($number);
        $tmp = $page*$number;
        $sql = "select * from x2_data where moduleid=$moduleid limit $tmp,$number";
        $stmt = $conn->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['data'] = $result;
        $results['number']=count($results['data']);
        $results['page']=$this->getPagesNumber($moduleid,$number);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getDataInfoListByWord($word,$moduleid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_data where moduleid=$moduleid";
        $stmt = $conn->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        $list = array();
        foreach ($results as $result)
        {
            if(strstr($result['datainfo'],$word))
            {
                $list[] = $result;
            }
        }
        return $list;
    }

}

