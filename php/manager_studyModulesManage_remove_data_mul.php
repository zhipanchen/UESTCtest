<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/17
 * Time: 15:03
 */
error_reporting(0);
$args = $_POST['dataids'];
$dataids = json_decode($args);
require_once './closed/data.php';
require_once './closed/dir.php';
$d = new dir();
$q = new data();
if(is_array($dataids))
{
    foreach ($dataids as $dataid)
    {
        $data = $q->getDataById($dataid);
        $d->delDir('files/data/'.$data['moduleid'].'/'.$dataid);
        $q->delDataById($dataid);

    }
}
echo json_encode(array('result'=>'success'));
?>