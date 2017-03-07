<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/1
 * Time: 1:41
 */
class data_app
{
    //输入：一个json,名args。args是数组，包括moduleid,datainfo,datachoicea,datachoiceb,datachoicec,datachoiced,
    //datanote(可以传null),dataanswer,datascore。6个文件data,a,b,c,d,note
    //输出：无
    //添加题目
    public function addData()
    {
        $args = json_decode($_POST['args']);
        $ques = $_FILES['data'];
        $a = $_FILES['a'];
        $b = $_FILES['b'];
        $c = $_FILES['c'];
        $d = $_FILES['d'];
        $note = $_FILES['note'];
        require_once 'dir.php';
        $di = new dir();
        $di->makeDirInFilesData("files");
        $di->makeDirInFilesData("files/data");
        $di->makeDirInFilesData("files/data/".$args['moduleid']);
        $di->makeDirInFilesData("files/data/".$args['moduleid'].'/'.md5($args['datainfo']));
        $datapicture = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/data.jpg";
        $datapicturea = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/a.jpg";
        $datapictureb = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/b.jpg";
        $datapicturec = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/c.jpg";
        $datapictured = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/d.jpg";
        $datanotepicture = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/note.jpg";
        move_uploaded_file($ques['tmp_name'],$datapicture);
        move_uploaded_file($a['tmp_name'],$datapicturea);
        move_uploaded_file($b['tmp_name'],$datapictureb);
        move_uploaded_file($c['tmp_name'],$datapicturec);
        move_uploaded_file($d['tmp_name'],$datapictured);
        move_uploaded_file($note['tmp_name'],$datanotepicture);
        $args['datapicture'] = $datapicture;
        $args['datapicturea'] = $datapicturea;
        $args['datapictureb'] = $datapictureb;
        $args['datapicturec'] = $datapicturec;
        $args['datapictured'] = $datapictured;
        $args['datanotepicture'] = $datanotepicture;
        require_once 'data.php';
        $ques = new data();
        $ques->addData($args);
    }

    //input:dataid
    //output:null
    //删除题目
    public function delData()
    {
        $dataid = $_POST['dataid'];
        require_once 'data.php';
        $q = new data();
        $data = $q->getDataById($dataid);
        require_once 'dir.php';
        $d = new dir();
        $d->delDir('files/data/'.$data['moduleid'].'/'.md5($data['datainfo']));
        $q->delDataById($dataid);
    }

    //输入：dataid,一个json,名args。args是数组，包括moduleid,datainfo,datachoicea,datachoiceb,datachoicec,datachoiced,
    //datanote(可以传null),dataanswer,datascore。6个文件data,a,b,c,d,note
    //输出：无
    //修改题目
    public function modData()
    {
        $dataid = $_POST['dataid'];
        $args = json_decode($_POST['args']);
        $ques = $_FILES['data'];
        $a = $_FILES['a'];
        $b = $_FILES['b'];
        $c = $_FILES['c'];
        $d = $_FILES['d'];
        $note = $_FILES['note'];
        require_once 'dir.php';
        $di = new dir();
        $di->makeDirInFilesData("files");
        $di->makeDirInFilesData("files/data");
        $di->makeDirInFilesData("files/data/".$args['moduleid']);
        $di->makeDirInFilesData("files/data/".$args['moduleid'].'/'.md5($args['datainfo']));
        $datapicture = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/data.jpg";
        $datapicturea = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/a.jpg";
        $datapictureb = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/b.jpg";
        $datapicturec = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/c.jpg";
        $datapictured = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/d.jpg";
        $datanotepicture = "files/data/".$args['moduleid']."/".md5($args['datainfo'])."/note.jpg";
        if($ques) {
            move_uploaded_file($ques['tmp_name'], $datapicture);
        }
        if($a) {
            move_uploaded_file($a['tmp_name'], $datapicturea);
        }
        if($b) {
            move_uploaded_file($b['tmp_name'], $datapictureb);
        }
        if($c) {
            move_uploaded_file($c['tmp_name'], $datapicturec);
        }
        if($d) {
            move_uploaded_file($d['tmp_name'], $datapictured);
        }
        if($note) {
            move_uploaded_file($note['tmp_name'], $datanotepicture);
        }
        $args['datapicture'] = $datapicture;
        $args['datapicturea'] = $datapicturea;
        $args['datapictureb'] = $datapictureb;
        $args['datapicturec'] = $datapicturec;
        $args['datapictured'] = $datapictured;
        $args['datanotepicture'] = $datanotepicture;
        require_once 'data.php';
        $ques = new data();
        $ques->modDataById($args,$dataid);
    }

}

