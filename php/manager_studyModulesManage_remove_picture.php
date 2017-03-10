<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/1/13
 * Time: 15:10
 */
error_reporting(0);
    require_once './closed/data.php';

    $dataid = $_POST['dataid'];
    $func = $_POST['func'];
    $d = new data();
    $data = $d->getDataById($dataid);
    $path = "files/data/".$data['moduleid']."/".$dataid."/".$func.".jpg";
    unlink($path);
    switch ($func)
    {
        case 'data':
            $d->modDataById(array("datapicture"=>""),$dataid);
            break;
        case 'a':
            $d->modDataById(array("datapicturea"=>""),$dataid);
            break;
        case 'b':
            $d->modDataById(array("datapictureb"=>""),$dataid);
            break;
        case 'c':
            $d->modDataById(array("datapicturec"=>""),$dataid);
            break;
        case 'd':
            $d->modDataById(array("datapictured"=>""),$dataid);
            break;
        case 'note':
            $d->modDataById(array("datanotepicture"=>""),$dataid);
            break;
    }
    echo json_encode(array('result'=>'success'));
?>