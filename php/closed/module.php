<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 4:09
 */
class module
{
    public function addModule($args)
    {
        require_once 'connect_db.php';
        $modulename=$args['modulename'];
        $conn = connectDb();
        $sql = "insert into x2_module(modulename) values ('$modulename')";
        $conn->exec($sql);
        $id = $conn->lastInsertId();
        $conn=null;
        return $id;
    }

    public function delModuleById($moduleid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "delete from x2_module where moduleid=$moduleid";
        $conn->exec($sql);
        $conn=null;
    }

    public function modModuleState($moduleid,$modulestate)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_module set modulestate=$modulestate where moduleid=$moduleid";
        $conn->query($sql);
        $conn=null;
    }

    public function modModuleName($moduleid,$modulename)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql="update x2_module set modulename='$modulename' where moduleid=$moduleid";
        $conn->exec($sql);
        $conn=null;
    }

    public function getModuleList()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_module";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }



    public function getActiveModule()
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_module where modulestate=1";
        $stmt = $conn->query($sql);
        $results['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results['number']=count($results['data']);
        $stmt=null;
        $conn=null;
        return $results;
    }

    public function getModuleByName($modulename)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_module where modulename='$modulename'";
        $stmt = $conn->query($sql);
        $module = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $module;
    }

    public function getModuleById($moduleid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_module where moduleid='$moduleid'";
        $stmt = $conn->query($sql);
        $module = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $module;
    }

    public function getModuleStateById($moduleid)
    {
        require_once 'connect_db.php';
        $conn = connectDb();
        $sql = "select * from x2_module where moduleid=$moduleid";
        $stmt = $conn->query($sql);
        $module = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt=null;
        $conn=null;
        return $module['modulestate'];
    }

}