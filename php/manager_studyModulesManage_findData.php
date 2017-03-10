<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/13
 * Time: 1:53
 */
    require_once 'closed/data.php';
    $word = $_POST['word'];
    $moduleid=$_POST['moduleid'];
    $d = new data();
    $list = $d->getDataInfoListByWord($word,$moduleid);
    echo json_encode($list);

//[{"dataid":"1","moduleid":"1","datainfo":"123","datachoicea":"a","datachoiceb":"b","datachoicec":"c","datachoiced":"d","datanote":null,"datapicture":null,"datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"A","datascore":"1"},{"dataid":"3","moduleid":"2","datainfo":"123","datachoicea":"a","datachoiceb":"b","datachoicec":"c","datachoiced":"d","datanote":null,"datapicture":null,"datapicturea":null,"datapictureb":null,"datapicturec":null,"datapictured":null,"datanotepicture":null,"dataanswer":"C","datascore":"1"}]
?>